<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::withCount('books')->orderBy('id', 'asc')->simplePaginate(5);
        return view('admin.authors', compact('authors'));
    }

    public function create()
    {
        return view('admin.authors-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:authors,name',
            'biography' => 'nullable|string',
        ]);

        Author::create([
            'name' => $request->name,
            'biography' => $request->biography,
        ]);

        return redirect()->route('admin.authors.index')->with('success', 'Author created successfully!');
    }

    public function show(Author $author)
    {
        return view('admin.authors-show', compact('author'));
    }

    public function edit(Author $author)
    {
        return view('admin.authors-edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:authors,name,' . $author->id,
            'biography' => 'nullable|string',
        ]);

        $author->update([
            'name' => $request->name,
            'biography' => $request->biography,
        ]);

        return redirect()->route('admin.authors.index')->with('success', 'Author updated successfully!');
    }

    public function destroy(Author $author)
    {
        // Check if author has books
        if ($author->books()->count() > 0) {
            return redirect()->route('admin.authors.index')->with('error', 'Cannot delete author with associated books!');
        }

        $author->delete();

        return redirect()->route('admin.authors.index')->with('success', 'Author deleted successfully!');
    }
}