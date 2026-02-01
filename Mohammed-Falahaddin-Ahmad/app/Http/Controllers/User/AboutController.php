<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Author;

class AboutController extends Controller
{

public function index()
{
    $authors = Author::withCount('books')->orderBy('books_count', 'desc')->take(6)->get();
    $latestReviews = \App\Models\Review::with(['user', 'book'])
        ->where('is_approved', true)
        ->latest()
        ->take(10)
        ->get();
        
    return view('user.about', compact('authors', 'latestReviews'));
}
}