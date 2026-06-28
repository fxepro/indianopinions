<?php

namespace App\Models;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
    use HasSlug;

    protected $fillable = [
        'user_id', 'title', 'slug', 'excerpt', 'content', 'featured_image',
        'status', 'author', 'reading_time', 'featured', 'published_at',
        'reviewed_by_id', 'published_by_id', 'reviewed_at',
        'editorial_notes', 'submission_notes',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'featured' => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug');
    }

    public function authorUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by_id');
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'published_by_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function workflowEvents(): HasMany
    {
        return $this->hasMany(PostWorkflowEvent::class)->latest('created_at');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', PostStatus::Published->value);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured', true);
    }

    public function scopeForUser(Builder $query, User $user): Builder
    {
        if ($user->isWriter()) {
            return $query->where('user_id', $user->id);
        }

        return $query;
    }

    public function scopeInReviewQueue(Builder $query): Builder
    {
        return $query->whereIn('status', [
            PostStatus::Submitted->value,
            PostStatus::InReview->value,
        ]);
    }

    public function getRouteKeyName(): string
    {
        return 'id';
    }

    public function statusEnum(): PostStatus
    {
        return PostStatus::tryFrom($this->status) ?? PostStatus::Draft;
    }

    public function getReadingTimeLabelAttribute(): string
    {
        $minutes = $this->attributes['reading_time'] ?? null;

        if ($minutes) {
            return $minutes.' min read';
        }

        if ($this->content) {
            $words = str_word_count(strip_tags($this->content));
            $minutes = max(1, (int) ceil($words / 200));

            return $minutes.' min read';
        }

        return '1 min read';
    }

    public function isEditableByWriter(): bool
    {
        return in_array($this->status, [
            PostStatus::Draft->value,
            PostStatus::ChangesRequested->value,
        ], true);
    }
}
