<?php

namespace App\Http\Controllers\Knowledge;

use App\Http\Controllers\Controller;
use App\Models\KnowledgeEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyContributionsController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $q = KnowledgeEntry::with(['tags', 'attachments'])
            ->where('company_id', $user->company_id)
            ->where('user_id', $user->id);

        // search (title + summary + content + tag name)
        if ($request->filled('search')) {
            $search = $request->search;
            $q->where(function ($qq) use ($search) {
                $qq->where('title', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhereHas('tags', function ($tq) use ($search) {
                      $tq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $q->where('status', $request->status);
        }

        // type filter
        if ($request->filled('type') && $request->type !== 'all') {
            $q->where('type', $request->type);
        }

        // sort
        $sort = $request->get('sort', 'newest');
        if ($sort === 'oldest') $q->orderBy('created_at', 'asc');
        elseif ($sort === 'title') $q->orderBy('title', 'asc');
        else $q->orderBy('created_at', 'desc');

        $entries = $q->paginate(6)->withQueryString();

        // stats (بدون فلترة - كل مساهماتي)
        $total = KnowledgeEntry::where('company_id', $user->company_id)->where('user_id', $user->id)->count();
        $approved = KnowledgeEntry::where('company_id', $user->company_id)->where('user_id', $user->id)->where('status', 'approved')->count();
        $pending = KnowledgeEntry::where('company_id', $user->company_id)->where('user_id', $user->id)->where('status', 'pending')->count();
        $rejected = KnowledgeEntry::where('company_id', $user->company_id)->where('user_id', $user->id)->where('status', 'rejected')->count();

        return view('site.innerPages.employee.myContributions', compact(
            'entries',
            'total',
            'approved',
            'pending',
            'rejected'
        ));
    }
}
