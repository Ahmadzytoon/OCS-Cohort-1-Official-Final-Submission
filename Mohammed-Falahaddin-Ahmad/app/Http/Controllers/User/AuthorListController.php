<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Author;

class AuthorListController extends Controller
{
    public function index()
    {
        $authors = Author::withCount('books')
            ->orderBy('books_count', 'desc')
            ->paginate(8);

        return view('user.author-list', compact('authors'));
    }
}