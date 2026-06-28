<?php

namespace Database\Seeders;

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\PostWorkflowEvent;
use App\Models\User;
use Illuminate\Database\Seeder;

class WorkflowHistoryBackfillSeeder extends Seeder
{
    public function run(): void
    {
        $fallbackUser = User::where('role', 'editor')->first()
            ?? User::first();

        Post::query()->each(function (Post $post) use ($fallbackUser) {
            if ($post->workflowEvents()->exists()) {
                return;
            }

            $actorId = $post->published_by_id
                ?? $post->reviewed_by_id
                ?? $post->user_id
                ?? $fallbackUser?->id;

            PostWorkflowEvent::create([
                'post_id' => $post->id,
                'user_id' => $actorId,
                'from_status' => null,
                'to_status' => PostStatus::Draft->value,
                'note' => 'Imported from legacy workflow state.',
                'created_at' => $post->created_at ?? now(),
            ]);

            if ($post->status !== PostStatus::Draft->value) {
                PostWorkflowEvent::create([
                    'post_id' => $post->id,
                    'user_id' => $actorId,
                    'from_status' => PostStatus::Draft->value,
                    'to_status' => $post->status,
                    'note' => $post->editorial_notes ?? $post->submission_notes,
                    'created_at' => $post->published_at ?? $post->reviewed_at ?? $post->updated_at ?? now(),
                ]);
            }
        });

        $this->command?->info('Backfilled workflow history for existing articles.');
    }
}
