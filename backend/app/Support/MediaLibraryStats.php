<?php

namespace App\Support;

use App\Models\GalleryImage;
use App\Models\MediaVideo;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;

class MediaLibraryStats
{
    /** @return list<array{label: string, value: int, sub: string}> */
    public static function gallery(): array
    {
        return self::build(GalleryImage::class, function (GalleryImage $image): array {
            return [$image->image_url];
        });
    }

    /** @return list<array{label: string, value: int, sub: string}> */
    public static function videos(): array
    {
        return self::build(MediaVideo::class, function (MediaVideo $video): array {
            $needles = array_filter([
                $video->video_url,
                $video->thumbnail_url,
                VideoUrl::embedUrl($video->video_url),
            ]);

            if ($youtubeId = VideoUrl::youtubeId($video->video_url)) {
                $needles[] = $youtubeId;
                $needles[] = "youtube.com/vi/{$youtubeId}";
                $needles[] = "youtu.be/{$youtubeId}";
            }

            if ($vimeoId = VideoUrl::vimeoId($video->video_url)) {
                $needles[] = $vimeoId;
                $needles[] = "vimeo.com/{$vimeoId}";
            }

            return array_values(array_unique($needles));
        });
    }

    /**
     * @param  class-string<Model>  $modelClass
     * @param  callable(Model): array<int, string|null>  $needlesFor
     * @return list<array{label: string, value: int, sub: string}>
     */
    private static function build(string $modelClass, callable $needlesFor): array
    {
        $weekAgo = now()->subWeek();
        $monthAgo = now()->subMonth();

        $total = $modelClass::query()->count();
        $lastWeek = $modelClass::query()->where('created_at', '>=', $weekAgo)->count();
        $lastMonth = $modelClass::query()->where('created_at', '>=', $monthAgo)->count();

        $haystack = self::articleHaystack();
        $used = 0;

        $modelClass::query()
            ->orderBy('id')
            ->chunkById(100, function ($items) use ($needlesFor, $haystack, &$used) {
                foreach ($items as $item) {
                    if (self::isUsedInArticles($haystack, $needlesFor($item))) {
                        $used++;
                    }
                }
            });

        $unused = max(0, $total - $used);

        return [
            ['label' => 'Total', 'value' => $total, 'sub' => 'in library'],
            ['label' => 'Last week', 'value' => $lastWeek, 'sub' => 'added'],
            ['label' => 'Last month', 'value' => $lastMonth, 'sub' => 'added'],
            ['label' => 'Used', 'value' => $used, 'sub' => 'in an article'],
            ['label' => 'Unused', 'value' => $unused, 'sub' => 'not in articles'],
        ];
    }

    private static function articleHaystack(): string
    {
        static $haystack = null;

        if ($haystack !== null) {
            return $haystack;
        }

        $haystack = Post::query()
            ->select(['content', 'featured_image'])
            ->get()
            ->map(fn (Post $post) => trim(($post->content ?? '').' '.($post->featured_image ?? '')))
            ->implode("\n");

        return $haystack;
    }

    /** @param  array<int, string|null>  $needles */
    private static function isUsedInArticles(string $haystack, array $needles): bool
    {
        if ($haystack === '') {
            return false;
        }

        foreach ($needles as $needle) {
            if (! is_string($needle) || $needle === '') {
                continue;
            }

            if (str_contains($haystack, $needle)) {
                return true;
            }
        }

        return false;
    }
}
