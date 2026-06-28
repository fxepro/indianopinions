@props([
    'title',
    'subtitle' => null,
])

<div {{ $attributes->merge(['class' => 'page-header']) }}>
    <div class="page-header-main">
        @isset($meta)
            <div class="page-header-meta">{{ $meta }}</div>
        @endisset
        <h1 class="page-title">{{ $title }}</h1>
        @if($subtitle)
            <p class="page-subtitle">{{ $subtitle }}</p>
        @endif
    </div>
    @isset($actions)
        <div class="page-header-actions">{{ $actions }}</div>
    @endisset
</div>
