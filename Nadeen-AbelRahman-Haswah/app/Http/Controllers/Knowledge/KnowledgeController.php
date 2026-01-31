<?php

namespace App\Http\Controllers\Knowledge;

use App\Http\Controllers\Controller;
use App\Models\KnowledgeEntry;
use App\Models\KnowledgeAttachment;
use App\Models\KnowledgeTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KnowledgeController extends Controller
{
    public function create()
    {
        return view('site.innerPages.employee.addknowledge');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // السماح فقط للـ employee و department_manager
        abort_unless(in_array($user->role, ['employee', 'department_manager']), 403);

        // لازم يكون الموظف مربوط بقسم + شركة (حسب فكرتك: داخل القسم)
        if (!$user->company_id || !$user->department_id) {
            return back()->withErrors([
                'general' => 'You must belong to a company and a department before adding knowledge.'
            ])->withInput();
        }

        // Validation عام
        $baseRules = [
            'type' => ['required', 'in:onboarding,mistakes,operational,critical'],
            'title' => ['required', 'string', 'max:191'],
            'summary' => ['required', 'string'],
            'tags' => ['nullable', 'string', 'max:500'],
            'attachments.*' => ['nullable', 'file', 'max:10240'],
            'action' => ['required', 'in:draft,submit'],
        ];
        // Validation حسب النوع (extra)
        $typeRules = [
            'onboarding' => [
                'content' => ['required', 'string'],
                'extra.timeline' => ['nullable', 'in:first-day,first-week,first-month,first-quarter'],
                'extra.key_takeaways' => ['nullable', 'string'],
            ],
            'mistakes' => [
                'extra.mistake' => ['required', 'string'],
                'extra.impact_level' => ['required', 'in:low,medium,high'],
                'extra.solution' => ['required', 'string'],
                'extra.lessons' => ['required', 'string'],
            ],
            'operational' => [
                'extra.task_name' => ['required', 'string', 'max:191'],
                'extra.frequency' => ['nullable', 'in:daily,weekly,monthly,as-needed'],
                'extra.tools' => ['nullable', 'string'],
                'extra.links' => ['nullable', 'string'],
                'extra.steps' => ['nullable', 'string'],
                'extra.common_issues' => ['nullable', 'string'],
            ],
            'critical' => [
                'extra.story' => ['required', 'string'],
                'extra.category' => ['nullable', 'in:promotion,project,decision,challenge,other'],
                'extra.success_factors' => ['required', 'string'],
                'extra.advice' => ['required', 'string'],
                'extra.skills' => ['nullable', 'string'],
            ],
        ];

        $type = $request->input('type');
        $rules = array_merge($baseRules, $typeRules[$type] ?? []);
        $validated = $request->validate($rules);

        // status
        $status = $validated['action'] === 'draft' ? 'draft' : 'pending';
        $submittedAt = $status === 'pending' ? now() : null;

        // إنشاء entry
        $entry = KnowledgeEntry::create([
            'company_id' => $user->company_id,
            'department_id' => $user->department_id,
            'user_id' => $user->id,
            'type' => $validated['type'],
            'title' => $validated['title'],
            'summary' => $validated['summary'],
            'content' => $validated['content'] ?? ($validated['summary'] ?? ''),
            'extra' => $validated['extra'] ?? null,
            'status' => $status,
            'submitted_at' => $submittedAt,
        ]);

        // Tags
        $this->syncTags($entry, $validated['tags'] ?? null);

        // Attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if (!$file) continue;

                $path = $file->store('knowledge-attachments', 'public');

                KnowledgeAttachment::create([
                    'knowledge_entry_id' => $entry->id,
                    'type' => $this->detectAttachmentType($file->getMimeType(), $file->getClientOriginalExtension()),
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                    'uploaded_by' => $user->id,
                ]);
            }
        }

        return redirect()->route('knowledge.knowledge.myContributions')
            ->with('swal', [
                'type' => 'success',
                'title' => 'Done',
                'text' => $status === 'draft'
                    ? 'Saved as draft successfully.'
                    : 'Submitted for approval successfully.'
            ]);
    }

    public function show(KnowledgeEntry $entry)
    {
        $user = Auth::user();

        // نفس الشركة
        abort_unless($entry->company_id === $user->company_id, 403);

        // عرض approved للجميع داخل القسم، لكن مسموح للكاتب يشوف حقه بأي status
        $isOwner = $entry->user_id === $user->id;

        if (!$isOwner) {
            // لازم نفس القسم + approved فقط
            abort_unless($entry->department_id === $user->department_id, 403);
            abort_unless($entry->status === 'approved', 403);

            // increment views_count
            $entry->increment('views_count');
        }

        $entry->load(['author', 'attachments', 'tags']);

        // ممكن تعمل view خاصة أو ترجع JSON لو بدك modal
        return view('site.innerPages.employee.knowledgeShow', compact('entry'));
    }

    public function edit(KnowledgeEntry $entry)
    {
        $user = Auth::user();
        abort_unless($entry->company_id === $user->company_id, 403);
        abort_unless($entry->user_id === $user->id, 403);

        // تعديل فقط draft/pending
        abort_unless(in_array($entry->status, ['draft', 'pending']), 403);

        $entry->load(['tags', 'attachments']);
        return view('site.innerPages.employee.editKnowledge', compact('entry'));
    }

    public function update(Request $request, KnowledgeEntry $entry)
    {
        $user = Auth::user();
        abort_unless($entry->company_id === $user->company_id, 403);
        abort_unless($entry->user_id === $user->id, 403);
        abort_unless(in_array($entry->status, ['draft', 'pending']), 403);

        // نفس منطق store (اختصرت للتوضيح — طبقي نفس rules)
        $baseRules = [
            'title' => ['required', 'string', 'max:191'],
            'summary' => ['required', 'string'],
            // 'content' => ['required', 'string'],
            'tags' => ['nullable', 'string', 'max:500'],
            'attachments.*' => ['nullable', 'file', 'max:10240'],
            'action' => ['required', 'in:draft,submit'],
        ];

        $validated = $request->validate($baseRules);

        $status = $validated['action'] === 'draft' ? 'draft' : 'pending';
        $submittedAt = $status === 'pending' ? now() : null;

        $entry->update([
            'title' => $validated['title'],
            'summary' => $validated['summary'],
            'content' => $validated['content'] ?? ($validated['summary'] ?? ''),
            'status' => $status,
            'submitted_at' => $submittedAt,
        ]);

        $this->syncTags($entry, $validated['tags'] ?? null);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if (!$file) continue;
                $path = $file->store('knowledge-attachments', 'public');

                KnowledgeAttachment::create([
                    'knowledge_entry_id' => $entry->id,
                    'type' => $this->detectAttachmentType($file->getMimeType(), $file->getClientOriginalExtension()),
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                    'uploaded_by' => $user->id,
                ]);
            }
        }

        return redirect()->route('knowledge.myContributions')
            ->with('swal', [
                'type' => 'success',
                'title' => 'Updated',
                'text' => 'Knowledge updated successfully.'
            ]);
    }

    public function destroy(KnowledgeEntry $entry)
    {
        $user = Auth::user();
        abort_unless($entry->company_id === $user->company_id, 403);
        abort_unless($entry->user_id === $user->id, 403);

        // احذف ملفات attachments من التخزين
        $entry->load('attachments');
        foreach ($entry->attachments as $att) {
            if ($att->path) Storage::disk('public')->delete($att->path);
        }

        $entry->delete();

        return back()->with('swal', [
            'type' => 'success',
            'title' => 'Deleted',
            'text' => 'Knowledge card deleted successfully.'
        ]);
    }

    // ---------------- Helpers ----------------

    private function syncTags(KnowledgeEntry $entry, ?string $tagsString): void
    {
        if (!$tagsString) {
            $entry->tags()->sync([]);
            return;
        }

        $names = collect(explode(',', $tagsString))
            ->map(fn($t) => trim($t))
            ->filter()
            ->unique()
            ->take(10);

        $tagIds = [];

        foreach ($names as $name) {
            $slug = Str::slug($name);

            $tag = KnowledgeTag::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'slug' => $slug]
            );

            $tagIds[] = $tag->id;
        }

        $entry->tags()->sync($tagIds);
    }

    private function detectAttachmentType(?string $mime, ?string $ext): string
    {
        $mime = strtolower($mime ?? '');
        $ext = strtolower($ext ?? '');

        if (str_starts_with($mime, 'image/')) return 'image';
        if ($mime === 'application/pdf' || $ext === 'pdf') return 'pdf';
        if (in_array($ext, ['doc', 'docx'])) return 'doc';
        if (str_starts_with($mime, 'video/')) return 'video';
        if (str_starts_with($mime, 'audio/')) return 'audio';

        return 'file';
    }
}
