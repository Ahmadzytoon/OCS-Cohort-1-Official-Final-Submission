<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function trash()
    {
        $products = Product::onlyTrashed()->with('category')->paginate(5);
        return view('admin.products.trash', compact('products'));
    }

    public function restore($id)
    {
        $product = Product::withTrashed()->find($id);

        if (!$product) {
            abort(404);
        }

        $product->restore();

        return redirect()->route('admin.products.trash')
            ->with('success', 'Product restored successfully');
    }
}
