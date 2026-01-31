<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KnowledgeEntry;
use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use App\Models\KnowledgeTag;
use App\Models\KnowledgeAttachment;
use Illuminate\Support\Str;

class KnowledgeEntrySeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();
        $users = User::all();
        $departments = Department::all();

        if ($companies->isEmpty() || $users->isEmpty() || $departments->isEmpty()) {
            $this->command->warn('Please seed companies, users and departments first!');
            return;
        }

        $types = ['onboarding', 'mistakes', 'operational', 'critical'];
        $statuses = ['draft', 'pending', 'approved'];

        foreach (range(1, 15) as $i) {
            $company = $companies->random();
            $department = $departments->where('company_id', $company->id)->random();
            $user = $users->where('company_id', $company->id)->random();

            $type = $types[array_rand($types)];
            $status = $statuses[array_rand($statuses)];

            $entry = KnowledgeEntry::create([
                'company_id' => $company->id,
                'department_id' => $department->id,
                'user_id' => $user->id,
                'type' => $type,
                'title' => ucfirst($type) . " Knowledge Sample #{$i}",
                'summary' => "This is a summary for {$type} knowledge card #{$i}.",
                'content' => $this->fakeContentByType($type),
                'extra' => $this->fakeExtraByType($type),
                'status' => $status,
                'submitted_at' => now()->subDays(rand(1, 30)),
                'approved_at' => $status === 'approved' ? now()->subDays(rand(0, 10)) : null,
                'approved_by' => $status === 'approved' ? $users->random()->id : null,
            ]);

            // Attach random tags
            $this->attachTags($entry);

            // Attach fake attachments
            $this->attachAttachments($entry, $user);
        }

        $this->command->info('Knowledge entries seeded successfully!');
    }

    private function fakeContentByType(string $type): string
    {
        return match ($type) {
            'onboarding' => 'Here are some things I wish I knew when I first joined the company...',
            'mistakes' => 'A mistake happened because of missing validation and poor communication...',
            'operational' => "1. Login to the system\n2. Navigate to dashboard\n3. Run the process\n4. Verify results",
            'critical' => 'This was a turning point in my career where I learned leadership under pressure...',
            default => 'General content...',
        };
    }

    private function fakeExtraByType(string $type): array
    {
        return match ($type) {
            'onboarding' => [
                'timeline' => 'first-month',
                'takeaways' => [
                    'Learn internal tools quickly',
                    'Ask questions early',
                    'Build relationships'
                ]
            ],
            'mistakes' => [
                'impact_level' => 'high',
                'solution' => 'Added validation and reviewed logic',
                'lesson' => 'Never skip edge cases'
            ],
            'operational' => [
                'task' => 'Deploying to Production',
                'frequency' => 'weekly',
                'tools' => ['Git', 'Docker', 'CI/CD'],
            ],
            'critical' => [
                'category' => 'promotion',
                'success_factors' => ['Consistency', 'Leadership'],
                'advice' => 'Always take responsibility'
            ],
            default => []
        };
    }

    private function attachTags(KnowledgeEntry $entry)
    {
        $tags = ['laravel', 'best-practice', 'teamwork', 'devops', 'career'];

        foreach (array_rand($tags, rand(1, 3)) as $index) {
            $tag = KnowledgeTag::firstOrCreate([
                'name' => ucfirst($tags[$index]),
                'slug' => Str::slug($tags[$index])
            ]);

            $entry->tags()->syncWithoutDetaching($tag->id);
        }
    }

    private function attachAttachments(KnowledgeEntry $entry, User $user)
    {
        if (rand(0, 1)) {
            KnowledgeAttachment::create([
                'knowledge_entry_id' => $entry->id,
                'type' => 'pdf',
                'path' => 'uploads/sample.pdf',
                'original_name' => 'sample.pdf',
                'size' => 123456,
                'mime' => 'application/pdf',
                'uploaded_by' => $user->id,
            ]);
        }
    }
}
