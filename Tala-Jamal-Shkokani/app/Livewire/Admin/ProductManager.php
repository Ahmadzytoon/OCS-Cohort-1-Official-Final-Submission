<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
#[Title('Gallery Management')]
class ProductManager extends Component
{
    use WithPagination;

    // Search and Filters
    #[Url(as: 'search')]
    public $search = '';

    #[Url(as: 'category')]
    public $categoryFilter = '';

    #[Url(as: 'aesthetic')]
    public $aestheticFilter = '';

    #[Url(as: 'status')]
    public $statusFilter = '';

    // Form/Details
    public $name, $description, $price, $discount_percentage = 0, $category_id, $image, $product_id, $aesthetic, $stock = 10, $status = 'active', $is_featured = false;
    public $colors = [];
    public $sizes = [];
    public $variant_stock = []; // Key: "color|size" -> quantity
    public $galleries = []; // Array of URL strings

    public $isEditMode = false;
    public $showProductSidebar = false;
    public $selectedProduct = null;

    // Sorting
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    // Selection
    public $selectAll = false;
    public $selectedRows = [];

    protected $paginationTheme = 'bootstrap';

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'name' => 'nullable|min:3',
            'price' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'stock' => 'nullable|integer|min:0',
            'variant_stock.*' => 'nullable|integer|min:0',
        ]);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedCategoryFilter()
    {
        $this->resetPage();
    }
    public function updatedAestheticFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedRows = Product::pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedRows = [];
        }
    }

    public function resetFilters()
    {
        $this->reset(['search', 'categoryFilter', 'aestheticFilter', 'statusFilter']);
        $this->resetPage();
    }

    public function openCreate()
    {
        $this->resetInputFields();
        $this->isEditMode = false;
        $this->showProductSidebar = true;
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $this->product_id = $id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->discount_percentage = $product->discount_percentage;
        $this->category_id = $product->category_id;
        $this->aesthetic = $product->aesthetic;
        $this->image = $product->image;
        $this->stock = $product->stock;
        $this->status = $product->status;
        $this->is_featured = $product->is_featured;
        $this->colors = $product->colors ?? [];
        $this->sizes = $product->sizes ?? [];

        // Load variants
        $this->variant_stock = [];
        foreach ($product->variants as $variant) {
            $this->variant_stock["{$variant->color}|{$variant->size}"] = $variant->stock;
        }

        // Load Gallery
        $this->galleries = $product->images->pluck('url')->toArray();

        $this->selectedProduct = $product;

        $this->isEditMode = true;
        $this->showProductSidebar = true;
    }

    public function updatedColors()
    {
        $this->syncVariants();
    }
    public function updatedSizes()
    {
        $this->syncVariants();
    }

    private function syncVariants()
    {
        $newVariantStock = [];

        if (!empty($this->colors) && !empty($this->sizes)) {
            foreach ($this->colors as $color) {
                foreach ($this->sizes as $size) {
                    $key = "{$color}|{$size}";
                    // Preserve existing value or default to 0
                    $newVariantStock[$key] = $this->variant_stock[$key] ?? 0;
                }
            }
        }

        $this->variant_stock = $newVariantStock;
        $this->syncTotalStock();
    }

    public function updatedVariantStock($value, $key)
    {
        $this->syncTotalStock();
    }

    private function syncTotalStock()
    {
        if (!empty($this->variant_stock)) {
            $this->stock = array_sum($this->variant_stock);
        }
    }

    public function save()
    {
        $rules = [
            'name' => 'required|min:3',
            'price' => 'required|numeric',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'aesthetic' => 'required|in:soft,alt,luxury,mix',
            'stock' => 'required|integer|min:0',
            'colors' => 'nullable|array',
            'sizes' => 'nullable|array',
        ];

        $this->validate($rules);

        // Sorting sizes logic...
        if (!empty($this->sizes)) {
            $sizeOrder = ['XXS' => 1, 'XS' => 2, 'S' => 3, 'M' => 4, 'L' => 5, 'XL' => 6, 'XXL' => 7, 'XXXL' => 8];
            usort($this->sizes, function ($a, $b) use ($sizeOrder) {
                return ($sizeOrder[strtoupper($a)] ?? 99) <=> ($sizeOrder[strtoupper($b)] ?? 99);
            });
        }

        $data = [
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'price' => $this->price,
            'discount_percentage' => $this->discount_percentage ?: 0,
            'category_id' => $this->category_id ?: null,
            'aesthetic' => $this->aesthetic,
            'image' => $this->image ?? 'https://via.placeholder.com/300',
            'stock' => $this->stock,
            'status' => $this->status,
            'is_featured' => $this->is_featured,
            'colors' => $this->colors,
            'sizes' => $this->sizes,
        ];

        if (!empty($this->variant_stock)) {
            $data['stock'] = array_sum($this->variant_stock);
        }

        $product = null;
        if ($this->isEditMode) {
            $product = Product::find($this->product_id);
            $product->update($data);
            $message = 'Piece updated.';
        } else {
            $product = Product::create($data);
            $message = 'New piece added to gallery.';
        }

        // Sync Variants Table
        $product->variants()->delete();
        foreach ($this->variant_stock as $key => $qty) {
            $parts = explode('|', $key);
            if (count($parts) === 2) {
                [$color, $size] = $parts;
                if (in_array($color, $this->colors ?? []) && in_array($size, $this->sizes ?? [])) {
                    $product->variants()->create([
                        'color' => $color,
                        'size' => $size,
                        'stock' => (int) $qty
                    ]);
                }
            }
        }

        // Sync Gallery Images Table
        $product->images()->delete();
        foreach (array_filter($this->galleries) as $index => $gUrl) {
            $product->images()->create([
                'url' => $gUrl,
                'alt_text' => $product->name . ' Detail',
                'is_primary' => false,
                'sort_order' => $index
            ]);
        }

        $this->showProductSidebar = false;
        $this->dispatch('swal:success', ['title' => 'Success', 'text' => $message, 'icon' => 'success']);
    }

    public function deleteProduct($id)
    {
        Product::find($id)->delete();
        $this->dispatch('swal:success', ['title' => 'Removed', 'text' => 'Piece deleted.', 'icon' => 'success']);
    }

    public function bulkDelete()
    {
        Product::whereIn('id', $this->selectedRows)->delete();
        $this->selectedRows = [];
        $this->selectAll = false;
        $this->dispatch('swal:success', ['title' => 'Bulk Action', 'text' => 'Selected pieces removed.', 'icon' => 'success']);
    }

    public function addGalleryImage()
    {
        $this->galleries[] = '';
    }

    public function removeGalleryImage($index)
    {
        unset($this->galleries[$index]);
        $this->galleries = array_values($this->galleries);
    }

    private function resetInputFields()
    {
        $this->reset(['name', 'description', 'price', 'discount_percentage', 'category_id', 'aesthetic', 'image', 'stock', 'status', 'is_featured', 'product_id', 'selectedProduct', 'colors', 'sizes', 'variant_stock', 'galleries']);
    }

    public function render()
    {
        $query = Product::with('category');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }

        if ($this->aestheticFilter) {
            $query->where('aesthetic', $this->aestheticFilter);
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $products = $query->orderBy($this->sortField, $this->sortDirection)->paginate(10);

        $stats = [
            'total' => Product::count(),
            'stock' => Product::sum('stock'),
            'featured' => Product::where('is_featured', true)->count(),
        ];

        return view('livewire.admin.product-manager', [
            'products' => $products,
            'categories' => Category::all(),
            'stats' => $stats
        ]);
    }
}
