<?php

namespace App\Http\Controllers\shared;

use App\Http\Controllers\Controller;
use App\Models\CompanyNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class CompanyNewsController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $companyId = $user->company_id;

        $q = CompanyNews::where('company_id', $companyId);

        // search
        if ($request->filled('search')) {
            $q->where('title', 'like', '%' . $request->search . '%');
        }

        // status filter
        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }

        // sort
        $sort = $request->get('sort', 'newest');
        if ($sort === 'oldest') $q->orderBy('created_at', 'asc');
        else $q->orderBy('created_at', 'desc');

        $news = $q->paginate(6)->withQueryString();

        // stats
        $total = CompanyNews::where('company_id', $companyId)->count();
        $published = CompanyNews::where('company_id', $companyId)->where('status', 'published')->count();
        $scheduled = CompanyNews::where('company_id', $companyId)->where('status', 'scheduled')->count();
        $drafts = CompanyNews::where('company_id', $companyId)->where('status', 'draft')->count();

        return view('site.innerPages.companyOwner.companyNews', compact(
            'news',
            'total',
            'published',
            'scheduled',
            'drafts'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:191'],
            'category' => ['nullable', 'in:company,product,hr,achievement,announcement,other'],
            'custom_category' => ['nullable', 'string', 'max:191'],
            'content' => ['required', 'string'],
            'publication_type' => ['required', 'in:now,schedule,draft'],
            'schedule_date' => ['nullable', 'date'],
            'schedule_time' => ['nullable', 'date_format:H:i'],
            'send_notification' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:2048'], // 2MB
        ]);

        // إذا category = other لازم custom_category
        if (($validated['category'] ?? null) === 'other' && empty($validated['custom_category'])) {
            return back()->withErrors(['custom_category' => 'Custom category is required.'])->withInput();
        }

        // تحديد الحالة والتواريخ
        $status = 'draft';
        $publishAt = null;
        $publishedAt = null;

        if ($validated['publication_type'] === 'now') {
            $status = 'published';
            $publishedAt = now();
        } elseif ($validated['publication_type'] === 'schedule') {
            $status = 'scheduled';

            if (empty($validated['schedule_date']) || empty($validated['schedule_time'])) {
                return back()->withErrors(['schedule_date' => 'Schedule date/time required.'])->withInput();
            }

            $publishAt = Carbon::parse($validated['schedule_date'] . ' ' . $validated['schedule_time']);
        }

        // image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('company-news', 'public');
        }

        CompanyNews::create([
            'company_id' => $user->company_id,
            'author_id' => $user->id, // company owner
            'title' => $validated['title'],
            'category' => $validated['category'] ?? null,
            'custom_category' => $validated['custom_category'] ?? null,
            'content' => $validated['content'],
            'status' => $status,
            'publish_at' => $publishAt,
            'published_at' => $publishedAt,
            'send_notification' => (bool)($validated['send_notification'] ?? true),
            'image' => $imagePath,
        ]);

        return back()->with('swal', [
            'type' => 'success',
            'title' => 'Done',
            'text' => 'News saved successfully.'
        ]);
    }

    public function update(Request $request, CompanyNews $news)
    {
        $user = Auth::user();
        abort_unless($news->company_id === $user->company_id, 403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:191'],
            'category' => ['nullable', 'in:company,product,hr,achievement,announcement,other'],
            'custom_category' => ['nullable', 'string', 'max:191'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:published,scheduled,draft'],
            'schedule_date' => ['nullable', 'date'],
            'schedule_time' => ['nullable', 'date_format:H:i'],
            'send_notification' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if (($validated['category'] ?? null) === 'other' && empty($validated['custom_category'])) {
            return back()->withErrors(['custom_category' => 'Custom category is required.'])->withInput();
        }

        // status handling
        $publishAt = null;
        $publishedAt = $news->published_at;

        if ($validated['status'] === 'published') {
            if (!$news->published_at) $publishedAt = now();
        } elseif ($validated['status'] === 'scheduled') {
            if (empty($validated['schedule_date']) || empty($validated['schedule_time'])) {
                return back()->withErrors(['schedule_date' => 'Schedule date/time required.'])->withInput();
            }
            $publishAt = Carbon::parse($validated['schedule_date'] . ' ' . $validated['schedule_time']);
            $publishedAt = null;
        } else { // draft
            $publishedAt = null;
        }

        // image replace
        $imagePath = $news->image;
        if ($request->hasFile('image')) {
            if ($news->image) Storage::disk('public')->delete($news->image);
            $imagePath = $request->file('image')->store('company-news', 'public');
        }

        $news->update([
            'title' => $validated['title'],
            'category' => $validated['category'] ?? null,
            'custom_category' => $validated['custom_category'] ?? null,
            'content' => $validated['content'],
            'status' => $validated['status'],
            'publish_at' => $publishAt,
            'published_at' => $publishedAt,
            'send_notification' => (bool)($validated['send_notification'] ?? $news->send_notification),
            'image' => $imagePath,
        ]);

        return back()->with('swal', [
            'type' => 'success',
            'title' => 'Updated',
            'text' => 'News updated successfully.'
        ]);
    }

    public function destroy(CompanyNews $news)
    {
        $user = Auth::user();
        abort_unless($news->company_id === $user->company_id, 403);

        if ($news->image) Storage::disk('public')->delete($news->image);
        $news->delete();

        return back()->with('swal', [
            'type' => 'success',
            'title' => 'Deleted',
            'text' => 'News deleted successfully.'
        ]);
    }

    public function publishNow(CompanyNews $news)
    {
        $user = Auth::user();
        abort_unless($news->company_id === $user->company_id, 403);

        $news->update([
            'status' => 'published',
            'publish_at' => null,
            'published_at' => now(),
        ]);

        return back()->with('swal', [
            'type' => 'success',
            'title' => 'Published',
            'text' => 'News published successfully.'
        ]);
    }

    public function unpublish(CompanyNews $news)
    {
        $user = Auth::user();
        abort_unless($news->company_id === $user->company_id, 403);

        $news->update([
            'status' => 'draft',
            'publish_at' => null,
            'published_at' => null,
        ]);

        return back()->with('swal', [
            'type' => 'success',
            'title' => 'Unpublished',
            'text' => 'News moved to Draft.'
        ]);
    }
}
