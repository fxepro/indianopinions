<?php

namespace App\Services;

use App\Models\IntelligenceBrief;
use Illuminate\Support\Collection;

class IntelligenceBriefService
{
    /** @return array<string, mixed>|null */
    public function resolveLatest(): ?array
    {
        $brief = IntelligenceBrief::published()
            ->orderByDesc('edition_date')
            ->with('items')
            ->first();

        return $brief ? $this->format($brief) : null;
    }

    /** @return array<string, mixed>|null */
    public function resolveByDate(string $date): ?array
    {
        if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return null;
        }

        $brief = IntelligenceBrief::published()
            ->forDate($date)
            ->with('items')
            ->first();

        return $brief ? $this->format($brief) : null;
    }

    /** @return list<string> */
    public function publishedDates(): array
    {
        return IntelligenceBrief::published()
            ->orderByDesc('edition_date')
            ->pluck('edition_date')
            ->map(fn ($date) => $date->format('Y-m-d'))
            ->all();
    }

    /** @return array<string, mixed> */
    private function format(IntelligenceBrief $brief): array
    {
        $labels = config('intelligence_brief.hub_labels', []);
        $editionDate = $brief->edition_date->format('Y-m-d');

        $leads = $brief->items
            ->where('type', 'lead')
            ->sortBy('position')
            ->values()
            ->map(fn ($item) => [
                'headline' => $item->headline,
                'blurb' => $item->blurb,
            ])
            ->all();

        $hubs = $brief->items
            ->where('type', 'hub')
            ->sortBy('position')
            ->values()
            ->map(fn ($item) => [
                'hub' => $labels[$item->hub_slug] ?? $item->hub_slug,
                'hub_slug' => $item->hub_slug,
                'blurb' => $item->blurb,
            ])
            ->all();

        $dates = $this->publishedDates();
        $index = array_search($editionDate, $dates, true);

        return [
            'edition_date' => $editionDate,
            'edition_label' => $brief->edition_date->format('l, j F Y'),
            'leads' => $leads,
            'hubs' => $hubs,
            'caveat' => config('intelligence_brief.caveat'),
            'previous_date' => ($index !== false && isset($dates[$index + 1])) ? $dates[$index + 1] : null,
            'next_date' => ($index !== false && $index > 0) ? $dates[$index - 1] : null,
        ];
    }
}
