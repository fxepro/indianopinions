<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IntelligenceBriefItem extends Model
{
    protected $fillable = [
        'intelligence_brief_id',
        'type',
        'hub_slug',
        'position',
        'headline',
        'blurb',
        'post_id',
    ];

    public function brief(): BelongsTo
    {
        return $this->belongsTo(IntelligenceBrief::class, 'intelligence_brief_id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function scopeLeads(Builder $query): Builder
    {
        return $query->where('type', 'lead');
    }

    public function scopeHubs(Builder $query): Builder
    {
        return $query->where('type', 'hub');
    }
}
