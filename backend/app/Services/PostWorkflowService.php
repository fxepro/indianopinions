<?php

namespace App\Services;

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\PostWorkflowEvent;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class PostWorkflowService
{
    /** @return list<PostStatus> */
    public function allowedTransitions(Post $post, User $actor): array
    {
        $from = $post->statusEnum();

        if ($actor->isWriter()) {
            return match ($from) {
                PostStatus::Draft, PostStatus::ChangesRequested => [PostStatus::Submitted],
                default => [],
            };
        }

        if (! $actor->isEditor()) {
            return [];
        }

        return match ($from) {
            PostStatus::Submitted => [
                PostStatus::InReview,
                PostStatus::Published,
                PostStatus::ChangesRequested,
                PostStatus::Rejected,
            ],
            PostStatus::InReview => [
                PostStatus::Published,
                PostStatus::ChangesRequested,
                PostStatus::Rejected,
            ],
            PostStatus::Published => [PostStatus::Archived],
            PostStatus::Archived => [PostStatus::Draft],
            PostStatus::Rejected => [PostStatus::Draft],
            default => [],
        };
    }

    public function noteRequired(PostStatus $from, PostStatus $to): bool
    {
        return in_array($to, [PostStatus::ChangesRequested, PostStatus::Rejected], true);
    }

    public function logCreated(Post $post, User $actor): void
    {
        if ($post->workflowEvents()->exists()) {
            return;
        }

        PostWorkflowEvent::create([
            'post_id' => $post->id,
            'user_id' => $actor->id,
            'from_status' => null,
            'to_status' => PostStatus::Draft->value,
            'note' => null,
            'created_at' => $post->created_at ?? now(),
        ]);
    }

    public function submit(Post $post, User $actor, ?string $notes = null): Post
    {
        return $this->transition($post, $actor, PostStatus::Submitted, $notes);
    }

    public function startReview(Post $post, User $editor): Post
    {
        return $this->transition($post, $editor, PostStatus::InReview);
    }

    public function requestChanges(Post $post, User $editor, string $notes): Post
    {
        return $this->transition($post, $editor, PostStatus::ChangesRequested, $notes);
    }

    public function publish(Post $post, User $editor, ?\DateTimeInterface $publishedAt = null): Post
    {
        $this->assertCanTransition($post, PostStatus::Published, $editor);

        return DB::transaction(function () use ($post, $editor, $publishedAt) {
            $from = $post->status;

            $this->recordEvent($post, $editor, $from, PostStatus::Published->value, null);

            $post->update([
                'status' => PostStatus::Published->value,
                'published_at' => $publishedAt ?? now(),
                'published_by_id' => $editor->id,
                'reviewed_by_id' => $editor->id,
                'reviewed_at' => now(),
            ]);

            return $post->fresh();
        });
    }

    public function reject(Post $post, User $editor, string $notes): Post
    {
        return $this->transition($post, $editor, PostStatus::Rejected, $notes);
    }

    public function unpublish(Post $post, User $editor, ?string $note = null): Post
    {
        return $this->transition($post, $editor, PostStatus::Archived, $note ?? 'Unpublished from site.');
    }

    public function transition(Post $post, User $actor, PostStatus $to, ?string $note = null): Post
    {
        $this->assertCanTransition($post, $to, $actor);

        if ($this->noteRequired($post->statusEnum(), $to) && blank(trim((string) $note))) {
            throw new InvalidArgumentException('A note is required for this status change.');
        }

        return DB::transaction(function () use ($post, $actor, $to, $note) {
            $from = $post->status;
            $updates = $this->buildPostUpdates($post, $actor, $to, $note);

            $this->recordEvent($post, $actor, $from, $to->value, $note);

            $post->update($updates);

            return $post->fresh();
        });
    }

    /** @return array<string, mixed> */
    private function buildPostUpdates(Post $post, User $actor, PostStatus $to, ?string $note): array
    {
        $updates = ['status' => $to->value];

        return match ($to) {
            PostStatus::Submitted => array_merge($updates, [
                'submission_notes' => $note,
                'editorial_notes' => null,
            ]),
            PostStatus::InReview => array_merge($updates, [
                'reviewed_by_id' => $actor->id,
                'reviewed_at' => now(),
            ]),
            PostStatus::ChangesRequested => array_merge($updates, [
                'editorial_notes' => $note,
                'reviewed_by_id' => $actor->id,
                'reviewed_at' => now(),
            ]),
            PostStatus::Rejected => array_merge($updates, [
                'editorial_notes' => $note,
                'reviewed_by_id' => $actor->id,
                'reviewed_at' => now(),
            ]),
            PostStatus::Published => array_merge($updates, [
                'published_at' => $post->published_at ?? now(),
                'published_by_id' => $actor->id,
                'reviewed_by_id' => $actor->id,
                'reviewed_at' => now(),
            ]),
            PostStatus::Archived => array_merge($updates, [
                'published_at' => null,
                'published_by_id' => null,
            ]),
            PostStatus::Draft => array_merge($updates, [
                'published_at' => null,
                'published_by_id' => null,
            ]),
            default => $updates,
        };
    }

    private function recordEvent(Post $post, User $actor, ?string $from, string $to, ?string $note): void
    {
        PostWorkflowEvent::create([
            'post_id' => $post->id,
            'user_id' => $actor->id,
            'from_status' => $from,
            'to_status' => $to,
            'note' => $note,
            'created_at' => now(),
        ]);
    }

    private function assertCanTransition(Post $post, PostStatus $to, User $actor): void
    {
        $allowed = $this->allowedTransitions($post, $actor);

        if (! in_array($to, $allowed, true)) {
            throw new InvalidArgumentException(
                "Cannot move from [{$post->statusEnum()->label()}] to [{$to->label()}]."
            );
        }
    }
}
