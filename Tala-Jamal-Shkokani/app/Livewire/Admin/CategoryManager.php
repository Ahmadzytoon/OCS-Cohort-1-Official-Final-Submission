<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
#[Title('Collection Manager')]
class CategoryManager extends Component
{
    use WithPagination;

    public $search = '';
    public $name, $slug, $discount_percentage, $image;
    public $categoryId;
    public $isEditMode = false;
    public $showDrawer = false;

    protected $rules = [
        'name' => 'required|min:2',
        'discount_percentage' => 'nullable|numeric|min:0|max:100',
        'image' => 'nullable|url',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openCreate()
    {
        $this->resetInputFields();
        $this->isEditMode = false;
        $this->showDrawer = true;
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->discount_percentage = $category->discount_percentage;
        $this->image = $category->image;

        $this->isEditMode = true;
        $this->showDrawer = true;
    }

    public function save()
    {
        $rules = $this->rules;
        $rules['name'] .= '|unique:categories,name,' . $this->categoryId;

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'discount_percentage' => $this->discount_percentage ?: 0,
            'image' => $this->image,
        ];

        if ($this->isEditMode) {
            Category::find($this->categoryId)->update($data);
            $message = 'Collection perfectly refined.';
        } else {
            Category::create($data);
            $message = 'New collection manifested.';
        }

        $this->showDrawer = false;
        $this->dispatch('swal:success', ['title' => 'Success', 'text' => $message]);
        $this->resetInputFields();
    }

    public function deleteCategory($id)
    {
        Category::find($id)->delete();
        $this->dispatch('swal:success', ['title' => 'Success', 'text' => 'Collection dissolved.']);
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->slug = '';
        $this->discount_percentage = 0;
        $this->image = '';
        $this->categoryId = null;
    }

    public function render()
    {
        $categories = Category::where('name', 'like', '%' . $this->search . '%')
            ->withCount('products')
            ->paginate(10);

        return view('livewire.admin.category-manager', [
            'categories' => $categories
        ]);
    }
}
