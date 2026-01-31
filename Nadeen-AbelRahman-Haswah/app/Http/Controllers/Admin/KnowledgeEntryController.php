<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KnowledgeEntry;
use Illuminate\Http\Request;

class KnowledgeEntryController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->get('search'));

        $items = KnowledgeEntry::with(['company', 'department', 'author'])
            ->when($search, function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('summary', 'like', "%{$search}%")
                    ->orWhereHas('company', function ($cq) use ($search) {
                        $cq->where('workspace_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('department', function ($dq) use ($search) {
                        $dq->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('author', function ($aq) use ($search) {
                        $aq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('admin.knowledgeItems', compact('items', 'search'));
    }

    public function show(KnowledgeEntry $knowledge_item)
    {
        $knowledge_item->load(['company', 'department', 'author', 'tags', 'attachments']);

        return view('admin.showKnowledgeItem', [
            'item' => $knowledge_item
        ]);
    }
}
