<?php

namespace App\Http\Resources;

use App\Support\VideoUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaVideoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $embedUrl = VideoUrl::embedUrl($this->video_url);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'video_url' => $this->video_url,
            'thumbnail_url' => VideoUrl::thumbnailUrl($this->video_url, $this->thumbnail_url),
            'embed_url' => $embedUrl,
            'provider' => VideoUrl::provider($this->video_url),
            'duration_seconds' => $this->duration_seconds,
            'category' => $this->category,
            'featured' => $this->featured,
            'published_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
