<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Earning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $author = $user->authorProfile;

        if (!$author) {
            // Auto-create or redirect to setup
            $author = \App\Models\Author::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'biography' => 'Professional Author',
            ]);
        }

        $totalBooks = $author->books()->count();
        $totalEarnings = $author->total_earnings;
        
        $myBookIds = $author->books()->pluck('id');
        $totalSales = OrderItem::whereIn('book_id', $myBookIds)->sum('quantity');

        $recentEarnings = Earning::where('author_id', $user->id)
            ->with('orderItem.book')
            ->latest()
            ->take(5)
            ->get();

        return view('author.dashboard', compact('totalBooks', 'totalEarnings', 'totalSales', 'recentEarnings'));
    }

    public function books()
    {
        $books = Auth::user()->authorProfile->books()->with('category')->paginate(10);
        return view('author.books.index', compact('books'));
    }

    public function createBook()
    {
        $user = Auth::user();
        if (!$user->subscription || !$user->subscription->isActive()) {
            return redirect()->route('user.plans')->with('error', 'You need an active subscription to publish books.');
        }

        $categories = Category::all();
        return view('author.books.create', compact('categories'));
    }

    public function storeBook(Request $request)
    {
        $user = Auth::user();
        $subscription = $user->subscription;
        if (!$subscription || !$subscription->isActive()) {
            return redirect()->route('user.plans')->with('error', 'You need an active subscription to publish books.');
        }

        $plan = $subscription->plan;
        if ($plan->book_limit > 0) {
            $currentBooks = $user->authorProfile->books()->count();
            if ($currentBooks >= $plan->book_limit) {
                return redirect()->route('author.books')->with('error', 'You have reached your plan limit of ' . $plan->book_limit . ' books.');
            }
        }

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'stock_quantity' => 'required|integer',
            'cover_image' => 'nullable|image',
        ]);

        $author = Auth::user()->authorProfile;

        $data = $request->all();
        $data['author_id'] = $author->id;
        $data['status'] = 'Active';

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('books', 'public');
            $data['cover_image'] = $path;
        }

        Book::create($data);

        return redirect()->route('author.books')->with('success', 'Book created successfully.');
    }

    public function editBook(Book $book)
    {
        $this->authorizeAuthor($book);
        $categories = Category::all();
        return view('author.books.edit', compact('book', 'categories'));
    }

    public function updateBook(Request $request, Book $book)
    {
        $this->authorizeAuthor($book);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock_quantity' => 'required|integer|min:0',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('cover_image');

        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($book->cover_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($book->cover_image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($book->cover_image);
            }
            $path = $request->file('cover_image')->store('books', 'public');
            $data['cover_image'] = $path;
        }

        $book->update($data);

        return redirect()->route('author.books')->with('success', 'Book updated successfully.');
    }

    private function authorizeAuthor(Book $book)
    {
        if ($book->author_id !== Auth::user()->authorProfile->id) {
            abort(403);
        }
    }
}
