@extends('layouts.admin')
@section('page_title', 'Videos')

@section('content')
@php
    $siteMediaUrl = rtrim(config('app.frontend_url', 'http://localhost:9002'), '/').'/media';
    $frontendUrl = config('app.frontend_url', 'http://localhost:9002');
    $videoPlayerItems = $videos->map(function ($video) {
        return [
            'id' => $video->id,
            'title' => $video->title ?: 'Untitled',
            'embed' => \App\Support\VideoUrl::embedUrl($video->video_url),
            'file' => \App\Support\VideoUrl::embedUrl($video->video_url) ? null : $video->video_url,
        ];
    })->values();
@endphp

<x-admin.page-header title="Videos" :subtitle="'Manage videos for the public Media page (Next.js at '.$frontendUrl.')'">
    <x-slot:actions>
        <a href="{{ $siteMediaUrl }}" target="_blank" rel="noopener"
           class="px-4 py-2 border border-zinc-300 hover:bg-zinc-50 text-zinc-700 text-sm font-medium rounded-lg transition">
            Preview on site ↗
        </a>
    </x-slot:actions>
</x-admin.page-header>

@include('partials.admin.media-stats')

<div class="mb-8"
     x-data="videoUploader()"
     x-init="init()"
     @dragover.prevent="dragging = true"
     @dragleave.prevent="dragging = false"
     @drop.prevent="onDrop($event)">

    <div class="media-dropzone"
         :class="{ 'is-dragging': dragging }"
         @click="$refs.fileInput.click()">

        <svg class="media-dropzone-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
        </svg>
        <p class="media-dropzone-title">Drop videos here, or <span class="media-dropzone-accent">browse</span></p>
        <p class="media-dropzone-hint">MP4, WebM, MOV · up to 500 MB each</p>

        <input type="file" x-ref="fileInput" multiple accept="video/mp4,video/webm,video/quicktime"
               class="hidden" @change="onFileInput($event)">
    </div>

    <div x-show="queue.length > 0" class="mt-4 space-y-2">
        <template x-for="(item, i) in queue" :key="i">
            <div class="flex items-center gap-3 bg-white border border-zinc-200 rounded-xl px-4 py-2.5">
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-medium text-zinc-700 truncate" x-text="item.name"></p>
                    <div class="mt-1 h-1.5 bg-zinc-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-200"
                             :class="item.error ? 'bg-red-400' : item.done ? 'bg-emerald-400' : 'bg-indigo-500'"
                             :style="`width: ${item.progress}%`"></div>
                    </div>
                </div>
                <span class="text-xs font-medium shrink-0"
                      :class="item.error ? 'text-red-500' : item.done ? 'text-emerald-600' : 'text-zinc-400'"
                      x-text="item.error ? 'Error' : item.done ? 'Done' : item.progress + '%'"></span>
            </div>
        </template>
    </div>
</div>

<div class="flex items-center justify-between mb-5">
    <div class="flex items-center gap-3">
        @if($categories->isNotEmpty())
            <form method="GET" action="{{ admin_route('admin.media-videos.index') }}">
                <select name="category" onchange="this.form.submit()"
                        class="text-sm border border-zinc-200 rounded-lg px-3 py-1.5 text-zinc-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </form>
        @endif
        <span class="text-xs text-zinc-400">{{ $videos->total() }} video{{ $videos->total() !== 1 ? 's' : '' }}</span>
    </div>
    <a href="{{ admin_route('admin.media-videos.create') }}"
       class="px-4 py-2 border border-zinc-300 hover:bg-zinc-50 text-zinc-700 text-sm font-medium rounded-lg transition">
        + Add by URL
    </a>
</div>

@if($videos->isNotEmpty())
    <div class="media-video-grid" x-data="videoLibrary(@js($videoPlayerItems))">
        @foreach($videos as $video)
            @php
                $thumb = \App\Support\VideoUrl::thumbnailUrl($video->video_url, $video->thumbnail_url);
            @endphp
            <article class="media-video-card">
                <button type="button" class="media-video-thumb" @click="active = {{ $video->id }}">
                    @if($thumb)
                        <img src="{{ $thumb }}" alt="">
                    @else
                        <span class="media-video-thumb-fallback">Video</span>
                    @endif
                    <span class="media-video-thumb-play" aria-hidden="true">
                        <span class="media-video-thumb-play-icon">▶</span>
                    </span>
                    @if($video->duration_seconds)
                        <span class="media-video-thumb-duration">
                            {{ gmdate($video->duration_seconds >= 3600 ? 'G:i:s' : 'i:s', $video->duration_seconds) }}
                        </span>
                    @endif
                </button>

                <div class="media-video-body">
                    <div class="media-video-header">
                        <button type="button" class="media-video-title-btn" @click="active = {{ $video->id }}">
                            <h3 class="media-video-title">{{ $video->title ?: 'Untitled' }}</h3>
                        </button>
                        @if($video->featured)
                            <span class="media-video-featured" title="Featured">★</span>
                        @endif
                    </div>
                    @if($video->category)
                        <p class="media-video-category">{{ $video->category }}</p>
                    @endif
                    @if($video->description)
                        <p class="media-video-description">{{ $video->description }}</p>
                    @endif
                    @unless($video->is_published)
                        <p class="media-video-draft">Draft — not on public site</p>
                    @endunless
                    <div class="media-video-actions">
                        <a href="{{ admin_route('admin.media-videos.edit', $video) }}" class="btn-edit">Edit</a>
                        <form method="POST" action="{{ admin_route('admin.media-videos.destroy', $video) }}"
                              onsubmit="return confirm('Delete this video?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-delete">Delete</button>
                        </form>
                    </div>
                </div>
            </article>
        @endforeach

        <template x-teleport="body">
            <div x-show="active"
                 x-cloak
                 class="media-video-modal-backdrop"
                 @keydown.escape.window="close()"
                 @click.self="close()">
                <div class="media-video-modal-panel">
                    <button type="button" class="media-video-modal-close" @click="close()">Close</button>
                    <p class="media-video-modal-title" x-text="current()?.title"></p>
                    <div class="media-video-modal-player">
                        <template x-if="current()?.embed">
                            <iframe :src="current()?.embed + '?autoplay=1'"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                        </template>
                        <template x-if="current()?.file">
                            <video :src="current()?.file" controls autoplay playsinline></video>
                        </template>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <div class="mt-6">{{ $videos->withQueryString()->links() }}</div>
@else
    <div class="bg-white rounded-xl border border-zinc-200 p-16 text-center text-zinc-400">
        <p class="text-sm">No videos yet — drag some in above or add a YouTube link.</p>
    </div>
@endif

@endsection

@push('scripts')
<script>
function videoLibrary(items) {
    return {
        active: null,
        items: items,
        current() {
            const id = this.active;
            return this.items.find(function (item) {
                return item.id === id;
            });
        },
        close() {
            this.active = null;
        },
    };
}

function videoUploader() {
    return {
        dragging: false,
        queue: [],

        init() {},

        onDrop(e) {
            this.dragging = false;
            this.handleFiles([...e.dataTransfer.files]);
        },

        onFileInput(e) {
            this.handleFiles([...e.target.files]);
            e.target.value = '';
        },

        handleFiles(files) {
            const videos = files.filter(f => f.type.startsWith('video/'));
            videos.forEach(file => this.uploadFile(file));
        },

        uploadFile(file) {
            const item = { name: file.name, progress: 0, done: false, error: false };
            this.queue.push(item);

            const fd = new FormData();
            fd.append('files[]', file);
            fd.append('_token', document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}');

            const xhr = new XMLHttpRequest();
            xhr.open('POST', @json(admin_route('admin.media-videos.upload')));

            xhr.upload.onprogress = e => {
                if (e.lengthComputable) item.progress = Math.round(e.loaded / e.total * 95);
            };

            xhr.onload = () => {
                item.progress = 100;
                if (xhr.status === 200) {
                    item.done = true;
                    setTimeout(() => window.location.reload(), 600);
                } else {
                    item.error = true;
                }
            };

            xhr.onerror = () => { item.error = true; item.progress = 100; };
            xhr.send(fd);
        },
    };
}
</script>
@endpush
