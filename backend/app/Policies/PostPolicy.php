<?php

namespace App\Policies;

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_articles');
    }

    public function view(User $user, Post $post): bool
    {
        if (! $user->hasPermission('view_articles')) {
            return false;
        }

        if ($user->isEditor()) {
            return true;
        }

        return $user->isWriter() && $post->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('create_articles');
    }

    public function update(User $user, Post $post): bool
    {
        if ($user->isEditor()) {
            return true;
        }

        return $user->isWriter()
            && $post->user_id === $user->id
            && $post->isEditableByWriter();
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->hasPermission('delete_articles');
    }

    public function submit(User $user, Post $post): bool
    {
        if (! $user->hasPermission('submit_articles')) {
            return false;
        }

        if ($user->isWriter() && $post->user_id !== $user->id) {
            return false;
        }

        return in_array($post->status, [
            PostStatus::Draft->value,
            PostStatus::ChangesRequested->value,
        ], true);
    }

    public function transition(User $user, Post $post): bool
    {
        return $user->isEditor();
    }

    public function review(User $user, Post $post): bool
    {
        return $user->hasPermission('review_articles')
            && in_array($post->status, [
                PostStatus::Submitted->value,
                PostStatus::InReview->value,
            ], true);
    }

    public function publish(User $user, Post $post): bool
    {
        return $user->hasPermission('publish_articles')
            && in_array($post->status, [
                PostStatus::Submitted->value,
                PostStatus::InReview->value,
            ], true);
    }

    public function unpublish(User $user, Post $post): bool
    {
        return $user->hasPermission('unpublish_articles')
            && $post->status === PostStatus::Published->value;
    }
}
