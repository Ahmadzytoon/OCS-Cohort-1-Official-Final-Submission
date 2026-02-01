<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::withCount('books')
            ->orderBy('books_count', 'desc')
            ->take(6)
            ->get();

        return view('user.about', compact('authors'));
    }
public function show(Author $author)
{
    $author->load([
        'books' => fn($query) => $query
            ->where('status', 'Active')
            ->with(['category', 'author', 'activeDiscount'])
            ->withAvg(['reviews' => fn($q) => $q->where('is_approved', true)], 'rating')
            ->withCount(['reviews' => fn($q) => $q->where('is_approved', true)])
            ->orderBy('created_at', 'desc')
    ]);

    if (auth()->check()) {
        $wishlistBookIds = \App\Models\Wishlist::where('user_id', auth()->id())
            ->pluck('book_id')
            ->toArray();
        
        $author->books->each(function ($book) use ($wishlistBookIds) {
            $book->wishlistedByUser = in_array($book->id, $wishlistBookIds);
        });
    }

    return view('user.author-show', compact('author'));
}
}