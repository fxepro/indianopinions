<?php

namespace App\Models;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostWorkflowEvent extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'post_id',
        'user_id',
        'from_status',
        'to_status',
        'note',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fromStatusEnum(): ?PostStatus
    {
        return $this->from_status ? PostStatus::tryFrom($this->from_status) : null;
    }

    public function toStatusEnum(): PostStatus
    {
        return PostStatus::tryFrom($this->to_status) ?? PostStatus::Draft;
    }
}
