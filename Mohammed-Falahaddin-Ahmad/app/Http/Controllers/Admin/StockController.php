<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\StockAdjustment;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('author', 'category')->orderBy('stock_quantity', 'asc');

        // Filter by stock level
        if ($request->has('stock_level') && $request->stock_level !== '') {
            switch ($request->stock_level) {
                case 'in_stock':
                    $query->where('stock_quantity', '>', 50);
                    break;
                case 'low_stock':
                    $query->whereBetween('stock_quantity', [1, 50]);
                    break;
                case 'out_of_stock':
                    $query->where('stock_quantity', 0);
                    break;
            }
        }

        $books = $query->simplePaginate(5); // Clean pagination
        return view('admin.stock', compact('books'));
    }

    public function adjustStock(Request $request, Book $book)
    {
        $request->validate([
            'quantity_change' => 'required|integer|min:-1000|max:1000',
            'reason' => 'nullable|string|max:255'
        ]);

        $previousStock = $book->stock_quantity;
        $newStock = $previousStock + $request->quantity_change;

        if ($newStock < 0) {
            return back()->withErrors(['quantity_change' => 'Cannot reduce stock below 0']);
        }

        // Update book stock
        $book->update(['stock_quantity' => $newStock]);

        // Record adjustment
        StockAdjustment::create([
            'book_id' => $book->id,
            'previous_stock' => $previousStock,
            'quantity_change' => $request->quantity_change,
            'new_stock' => $newStock,
            'reason' => $request->reason
        ]);

        return redirect()->route('admin.stock.index')->with('success', 'Stock adjusted successfully!');
    }

    public function showHistory(Book $book)
    {
        $adjustments = StockAdjustment::where('book_id', $book->id)
                         ->orderBy('created_at', 'desc')
                         ->paginate(5);

        return view('admin.stock-history', compact('book', 'adjustments'));
    }
}
