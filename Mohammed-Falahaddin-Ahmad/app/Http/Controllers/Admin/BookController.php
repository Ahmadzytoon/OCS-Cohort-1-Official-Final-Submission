<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\BookDiscount; // ADD THIS
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // ADD THIS ← CRITICAL FIX

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['author', 'category', 'activeDiscount'])
            ->orderBy('id', 'asc')
            ->simplePaginate(5);
        $categories = Category::all();
        return view('admin.books', compact('books', 'categories'));
    }

    public function create()
    {
        $authors = Author::all();
        $categories = Category::all();
        return view('admin.books-create', compact('authors', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0|max:999999.99',
            'stock_quantity' => 'required|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        $bookData = $request->except('cover_image');

        if ($request->hasFile('cover_image')) {
            $imageName = time() . '.' . $request->cover_image->extension();
            $request->cover_image->move(public_path('uploads/books'), $imageName);
            $bookData['cover_image'] = $imageName;
        }

        Book::create($bookData);

        return redirect()->route('admin.books.index')->with('success', 'Book created successfully!');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully!');
    }

    public function edit(Book $book)
    {
        $authors = Author::all();
        $categories = Category::all();
        return view('admin.books-edit', compact('book', 'authors', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0|max:999999.99',
            'stock_quantity' => 'required|integer|min:0',
            'status' => 'required|in:Active,Inactive',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        $bookData = $request->except('cover_image');

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                $oldImagePath = public_path('uploads/books/' . $book->cover_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $imageName = time() . '.' . $request->cover_image->extension();
            $request->cover_image->move(public_path('uploads/books'), $imageName);
            $bookData['cover_image'] = $imageName;
        }

        $book->update($bookData);

        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully!');
    }

    public function show(Book $book)
    {
        return view('admin.books-show', compact('book'));
    }

    /**
 * Apply or update discount for a book
 */
public function storeDiscount(Request $request, Book $book)
{
    $request->validate([
        'discount_type' => 'required|in:percentage,fixed',
        'discount_amount' => [
            'required',
            'numeric',
            'min:0',
            function ($attribute, $value, $fail) use ($request, $book) {
                if ($request->discount_type === 'percentage' && $value > 100) {
                    $fail('Percentage discount cannot exceed 100%.');
                }
                if ($request->discount_type === 'fixed' && $value > $book->price) {
                    $fail('Fixed discount cannot exceed book price ($' . number_format($book->price, 2) . ').');
                }
            },
        ],
        'valid_until' => 'nullable|date|after_or_equal:today',
    ]);

    DB::transaction(function () use ($request, $book) {
        // Deactivate existing active discount
        BookDiscount::where('book_id', $book->id)
            ->where('is_active', true)
            ->update(['is_active' => false]);

        // Create new active discount
        BookDiscount::create([
            'book_id' => $book->id,
            'discount_type' => $request->discount_type,
            'discount_amount' => $request->discount_amount,
            'valid_until' => $request->valid_until,
            'is_active' => true,
        ]);
    });

    // Return JSON for AJAX requests
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => "Discount successfully applied to '{$book->title}'!"
        ]);
    }

    return redirect()->route('admin.books.index')
        ->with('success', "Discount successfully applied to '{$book->title}'!");
}

/**
 * Remove active discount from book
 */
public function removeDiscount(Book $book)
{
    $discount = BookDiscount::where('book_id', $book->id)
        ->where('is_active', true)
        ->first();

    if ($discount) {
        $discount->update(['is_active' => false]);
        
        // Return JSON for AJAX requests
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Discount removed from '{$book->title}'!"
            ]);
        }

        return redirect()->route('admin.books.index')
            ->with('success', "Discount removed from '{$book->title}'!");
    }

    // Return JSON for AJAX requests
    if (request()->ajax()) {
        return response()->json([
            'success' => false,
            'message' => 'No active discount found for this book.'
        ]);
    }

    return redirect()->route('admin.books.index')
        ->with('error', 'No active discount found for this book.');
}
}
