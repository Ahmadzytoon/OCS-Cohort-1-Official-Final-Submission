<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Http\JsonResponse;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = Wishlist::where('user_id', auth()->id())
            ->with(['book' => function($q) {
                $q->with(['author', 'category'])->withAvg('reviews', 'rating');
            }])
            ->latest()
            ->paginate(6);

        return view('user.wishlist', compact('wishlist'));
    }

    public function add(Request $request, $bookId)
    {
        Wishlist::firstOrCreate([
            'user_id' => auth()->id(),
            'book_id' => $bookId
        ]);

        return response()->json(['success' => true]);
    }

    public function remove(Request $request, $bookId): JsonResponse
    {
        $deleted = Wishlist::where('user_id', auth()->id())
            ->where('book_id', $bookId)
            ->delete();

        if ($deleted) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Not found in wishlist'], 404);
    }
}