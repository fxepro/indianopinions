<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IntelligenceBrief extends Model
{
    protected $fillable = [
        'edition_date',
        'published_at',
    ];

    protected $casts = [
        'edition_date' => 'date',
        'published_at' => 'datetime',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(IntelligenceBriefItem::class)->orderBy('position');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function scopeForDate(Builder $query, string $date): Builder
    {
        return $query->whereDate('edition_date', $date);
    }
}
