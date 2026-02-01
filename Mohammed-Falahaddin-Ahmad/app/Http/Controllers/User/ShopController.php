<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Review;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    // ===============================
    // SHOP LIST
    // ===============================
    public function index(Request $request)
    {
        $query = Book::with(['author', 'category'])
            ->withAvg('reviews', 'rating')
            ->where('status', 'Active');

        // Search
        if ($request->filled('q')) {
            $search = trim($request->q);
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%$search%")
                  ->orWhere('isbn', 'LIKE', "%$search%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $catId = $request->category;
            $category = Category::find($catId);
            
            if ($category) {
                if ($category->isParent()) {
                    // Get IDs of all children plus the parent itself
                    $categoryIds = $category->children()->pluck('id')->push($category->id);
                    $query->whereIn('category_id', $categoryIds);
                } else {
                    $query->where('category_id', $catId);
                }
            }
        }

        // Rating Filter
        if ($request->filled('rating')) {
            $query->having('reviews_avg_rating', '>=', (int)$request->rating);
        }

        // Price Filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Stock Filter
        if ($request->filled('in_stock')) {
            if ($request->in_stock == '1') {
                $query->where('stock_quantity', '>', 0);
            } elseif ($request->in_stock == '0') {
                $query->where('stock_quantity', '<=', 0);
            }
        }

        // On Sale Filter
        if ($request->filled('on_sale')) {
            $query->whereHas('activeDiscount', function($q) {
                $q->where('is_active', true);
            });
        }

        // Sorting Logic
        $sort = $request->get('sort', 'default');
        switch ($sort) {
            case 'latest':
                $query->latest();
                break;
            case 'oldest':
                $query->oldest();
                break;
            case 'price_low_high':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high_low':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->orderBy('reviews_avg_rating', 'desc');
                break;
            case 'best_selling':
                $query->withSum(['orderItems as total_sold' => function($q) {
                    $q->whereHas('order', function($oq) {
                        $oq->where('order_status', 'delivered');
                    });
                }], 'quantity')->orderBy('total_sold_sum_quantity', 'desc');
                break;
            case 'default':
            default:
                $query->latest();
                break;
        }

        $books = $query->paginate(12)->withQueryString();
        $categories = Category::whereNull('parent_id')->with('children')->get();

        if (Auth::check()) {
            $wishlistBookIds = Wishlist::where('user_id', Auth::id())
                ->pluck('book_id')
                ->toArray();
            
            $books->getCollection()->each(function ($book) use ($wishlistBookIds) {
                $book->wishlistedByUser = in_array($book->id, $wishlistBookIds);
            });
        }

        return view('user.shop', compact('books', 'categories', 'sort'));
    }
    // ===============================
    // BOOK DETAILS
    // ===============================
    public function show(Book $book)
    {
        if ($book->status !== 'Active') {
            abort(404);
        }

        $approvedReviews = $book->reviews()
            ->where('is_approved', true)
            ->latest()
            ->get();

        $relatedBooks = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->where('status', 'Active')
            ->with(['author', 'category', 'activeDiscount'])
            ->withAvg(['reviews' => fn($q) => $q->where('is_approved', true)], 'rating')
            ->withCount(['reviews' => fn($q) => $q->where('is_approved', true)])
            ->take(4)
            ->get();

        $hasPurchased = false;
        $alreadyReviewed = false;
        if (Auth::check()) {
            $hasPurchased = \App\Models\Order::where('user_id', Auth::id())
                ->where('order_status', 'delivered')
                ->whereHas('items', function ($query) use ($book) {
                    $query->where('product_id', $book->id);
                })
                ->exists();

            $alreadyReviewed = \App\Models\Review::where('book_id', $book->id)
                ->where('user_id', Auth::id())
                ->exists();
        }

        return view('user.shop-details', compact(
            'book',
            'relatedBooks',
            'approvedReviews',
            'hasPurchased',
            'alreadyReviewed'
        ));
    }

    // ===============================
    // REVIEWS
    // ===============================
    public function storeReview(Request $request, Book $book)
    {
        if (!Auth::check()) {
            return back()->with('error', 'Please login to submit a review.');
        }

        $hasPurchased = \App\Models\Order::where('user_id', Auth::id())
            ->where('order_status', 'delivered')
            ->whereHas('items', function ($query) use ($book) {
                $query->where('product_id', $book->id);
            })
            ->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'You can only review books you have purchased and received.');
        }

        $alreadyReviewed = Review::where('book_id', $book->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'You have already reviewed this book.');
        }

        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000'
        ]);

        Review::create([
            'book_id'        => $book->id,
            'user_id'        => Auth::id(),
            'customer_name'  => Auth::user()->name,
            'customer_email' => Auth::user()->email,
            'rating'         => $request->rating,
            'comment'        => $request->comment,
            'is_approved'    => true
        ]);

        return back()->with('success', 'Your review has been submitted.');
    }

    // ===============================
    // CART
    // ===============================
  



public function cart()
{
    $cart = Cart::where('user_id', Auth::id())
        ->with('items.book')
        ->first();

    $total = 0;

    if ($cart) {
        foreach ($cart->items as $item) {
            if ($item->book) {
                // Calculate item price with book discount
                $itemPrice = $item->book->discount_amount > 0 
                    ? ($item->book->discount_type === 'percentage' 
                        ? $item->book->price - ($item->book->price * $item->book->discount_amount / 100)
                        : $item->book->price - $item->book->discount_amount)
                    : $item->book->price;
                $total += $itemPrice * $item->quantity;
            }
        }
    }

    // Calculate final total with coupon discount
    $finalTotal = $total;
    $couponDiscount = session('coupon_discount', 0);

    // Apply coupon discount if valid
    if ($couponDiscount > 0 && $couponDiscount <= $total) {
        $finalTotal = $total - $couponDiscount;
    }

    return view('user.shop-cart', compact('cart', 'total', 'finalTotal'));
}

/**
 * Apply coupon to cart
 */
public function applyCoupon(Request $request)
{
    $request->validate([
        'coupon_code' => 'required|string|exists:coupons,code'
    ]);

    $couponCode = strtoupper(trim($request->coupon_code));
    $coupon = Coupon::where('code', $couponCode)->first();

    if (!$coupon) {
        return back()->with('error', 'Invalid coupon code.');
    }

    // Calculate cart total
    $cart = Cart::where('user_id', Auth::id())->with('items.book')->first();
    $cartTotal = 0;

    if ($cart) {
        foreach ($cart->items as $item) {
            if ($item->book) {
                $itemPrice = $item->book->discount_amount > 0 
                    ? ($item->book->discount_type === 'percentage' 
                        ? $item->book->price - ($item->book->price * $item->book->discount_amount / 100)
                        : $item->book->price - $item->book->discount_amount)
                    : $item->book->price;
                $cartTotal += $itemPrice * $item->quantity;
            }
        }
    }

    // Validate coupon
    if (!$coupon->isValid($cartTotal)) {
        if (!$coupon->is_active) {
            return back()->with('error', 'This coupon is inactive.');
        }
        if ($coupon->expires_at && $coupon->expires_at->isPast()) {
            return back()->with('error', 'This coupon has expired.');
        }
        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return back()->with('error', 'This coupon has reached its usage limit.');
        }
        if ($coupon->min_order_amount && $cartTotal < $coupon->min_order_amount) {
            return back()->with('error', 'Minimum order amount of $' . number_format($coupon->min_order_amount, 2) . ' required.');
        }
        return back()->with('error', 'This coupon is not valid.');
    }

    // Calculate discount
    $discount = $coupon->calculateDiscount($cartTotal);

    // Store in session
    session(['applied_coupon' => [
        'code' => $coupon->code,
        'discount_type' => $coupon->discount_type,
        'discount_value' => $coupon->discount_value,
        'id' => $coupon->id
    ]]);
    session(['coupon_discount' => $discount]);

    return back()->with('success', 'Coupon applied successfully! You saved $' . number_format($discount, 2));
}

/**
 * Remove applied coupon
 */
public function removeCoupon()
{
    session()->forget(['applied_coupon', 'coupon_discount']);
    return back()->with('success', 'Coupon removed successfully.');
}





    public function addToCart(Book $book)
    {
        if ($book->status !== 'Active') {
            abort(404);
        }

        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id()
        ]);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('book_id', $book->id)
            ->first();

        if ($item) {
            $item->increment('quantity');
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'book_id' => $book->id,
                'quantity' => 1
            ]);
        }

        return redirect()->route('user.shop-cart')
            ->with('success', 'Book added to cart.');
    }

    public function updateCart(Request $request)
    {
        foreach ($request->qty as $itemId => $qty) {
            CartItem::where('id', $itemId)
                ->update(['quantity' => max(1, (int)$qty)]);
        }

        return back()->with('success', 'Cart updated.');
    }

    public function removeFromCart($id)
    {
        CartItem::where('id', $id)->delete();
        return back()->with('success', 'Item removed.');
    }

    // ===============================
    // WISHLIST
    // ===============================
    public function wishlist()
    {
        $items = Wishlist::where('user_id', Auth::id())
            ->with('book')
            ->get();

        return view('user.wishlist', compact('items'));
    }

    public function addToWishlist(Book $book)
    {
        Wishlist::firstOrCreate([
            'user_id' => Auth::id(),
            'book_id' => $book->id
        ]);

        return back()->with('success', 'Added to wishlist.');
    }

    public function removeFromWishlist($id)
    {
        Wishlist::where('id', $id)->delete();
        return back()->with('success', 'Removed from wishlist.');
    }
    
}
