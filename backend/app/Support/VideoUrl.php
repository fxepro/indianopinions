<?php

namespace App\Support;

class VideoUrl
{
    public static function provider(string $url): string
    {
        if (self::youtubeId($url)) {
            return 'youtube';
        }

        if (self::vimeoId($url)) {
            return 'vimeo';
        }

        return 'file';
    }

    public static function youtubeId(string $url): ?string
    {
        $patterns = [
            '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/shorts\/([a-zA-Z0-9_-]{11})/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    public static function vimeoId(string $url): ?string
    {
        if (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    public static function embedUrl(string $url): ?string
    {
        if ($id = self::youtubeId($url)) {
            return "https://www.youtube.com/embed/{$id}";
        }

        if ($id = self::vimeoId($url)) {
            return "https://player.vimeo.com/video/{$id}";
        }

        return null;
    }

    public static function thumbnailUrl(string $url, ?string $stored = null): ?string
    {
        if (filled($stored)) {
            return $stored;
        }

        if ($id = self::youtubeId($url)) {
            return "https://img.youtube.com/vi/{$id}/maxresdefault.jpg";
        }

        if ($id = self::vimeoId($url)) {
            return "https://vumbnail.com/{$id}.jpg";
        }

        return null;
    }

    public static function isSupported(string $url): bool
    {
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        if (self::embedUrl($url)) {
            return true;
        }

        return (bool) preg_match('/\.(mp4|webm|mov|m4v|ogg)(\?|$)/i', $url)
            || str_contains($url, '/storage/');
    }

    public static function normalize(string $url): string
    {
        return trim($url);
    }
}
