<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Featured Books: Highest rated or editor's choice (currently latest active)
        $featuredBooks = Book::with(['author', 'category', 'activeDiscount'])
            ->where('status', 'Active')
            ->withAvg(['reviews' => fn($q) => $q->where('is_approved', true)], 'rating')
            ->latest()
            ->take(8)
            ->get();

        // 2. Top Categories Book: Parent categories only
        $topCategories = Category::whereNull('parent_id')
            ->where('name', '!=', 'Education & Learning')
            ->with(['children.books' => function($q) {
                $q->where('status', 'Active');
            }, 'books' => function($q) {
                $q->where('status', 'Active');
            }])
            ->get()
            ->sortByDesc(function($category) {
                return $category->total_books_count;
            })
            ->take(4);

        // 3. Top Selling Books: Based on actual order items
        $topSellingBooks = Book::with(['author', 'category', 'activeDiscount'])
            ->where('status', 'Active')
            ->withCount('orderItems')
            ->withAvg(['reviews' => fn($q) => $q->where('is_approved', true)], 'rating')
            ->orderBy('order_items_count', 'desc')
            ->take(8)
            ->get();

        // 4. Top Rating Books: Based on average rating from reviews
        $topRatingBooks = Book::with(['author', 'category', 'activeDiscount'])
            ->where('status', 'Active')
            ->withAvg(['reviews' => fn($q) => $q->where('is_approved', true)], 'rating')
            ->orderBy('reviews_avg_rating', 'desc')
            ->take(6)
            ->get();

        // 5. Readit Top Books: A mix of high sales and ratings
        $readitTopBooks = Book::with(['author', 'category', 'activeDiscount'])
            ->where('status', 'Active')
            ->withCount('orderItems')
            ->withAvg(['reviews' => fn($q) => $q->where('is_approved', true)], 'rating')
            ->orderBy('order_items_count', 'desc')
            ->orderBy('reviews_avg_rating', 'desc')
            ->take(4)
            ->get();

        $featuredAuthors = Author::withCount('books')
            ->orderBy('books_count', 'desc')
            ->take(4)
            ->get();

        // 7. Latest Approved Reviews (Testimonials)
        $latestReviews = \App\Models\Review::with(['user', 'book'])
            ->where('is_approved', true)
            ->latest()
            ->take(6)
            ->get();

        // News (placeholder or real)
        $news = [];

        // Wishlist IDs for the current user
        $wishlist = [];
        if (auth()->check()) {
            $wishlist = \App\Models\Wishlist::where('user_id', auth()->id())
                ->pluck('book_id', 'book_id')
                ->toArray();
        }

        return view('user.index', compact(
            'featuredBooks',
            'topCategories',
            'readitTopBooks',
            'topRatingBooks',
            'topSellingBooks',
            'featuredAuthors',
            'news',
            'latestReviews',
            'wishlist'
        ));
    }
}