@php
$user = auth()->user();

$nav = [];

if ($user->can('view_dashboard')) {
    $nav[] = ['section' => 'Editorial', 'route' => 'admin.dashboard', 'label' => 'Dashboard', 'active' => 'admin.dashboard'];
}

if ($user->can('view_articles')) {
    $nav[] = ['section' => 'Editorial', 'route' => 'admin.posts.index', 'label' => 'Articles', 'active' => 'admin.posts.*'];
}

if ($user->can('view_review_queue')) {
    $nav[] = ['section' => 'Editorial', 'route' => 'admin.review.index', 'label' => 'Review Queue', 'active' => 'admin.review.*'];
}

if ($user->can('manage_layout')) {
    $nav[] = ['section' => 'Orchestration', 'route' => 'admin.layout.homepage', 'label' => 'Homepage', 'active' => 'admin.layout.homepage*'];
}

if ($user->can('manage_categories')) {
    $nav[] = ['section' => 'Newsroom Desk', 'route' => 'admin.categories.index', 'label' => 'Categories', 'active' => 'admin.categories.*'];
}

if ($user->can('manage_tags')) {
    $nav[] = ['section' => 'Newsroom Desk', 'route' => 'admin.tags.index', 'label' => 'Tags', 'active' => 'admin.tags.*'];
}

if ($user->can('manage_gallery')) {
    $nav[] = ['section' => 'Newsroom Desk', 'route' => 'admin.gallery.index', 'label' => 'Gallery', 'active' => 'admin.gallery.*'];
}

if ($user->can('manage_staff')) {
    $nav[] = ['section' => 'Administration', 'route' => 'admin.users.index', 'label' => 'Staff', 'active' => 'admin.users.*'];
}

if ($user->can('view_permissions_matrix')) {
    $nav[] = ['section' => 'Administration', 'route' => 'admin.permissions.index', 'label' => 'Permissions', 'active' => 'admin.permissions.*'];
}

$sections = collect($nav)->groupBy('section');
@endphp

<aside class="admin-sidebar">
    <div class="admin-sidebar-brand">
        <h1>Indian Opinions</h1>
        <p>Editorial Publishing House</p>
    </div>

    <nav class="admin-sidebar-nav">
        @foreach($sections as $section => $links)
            <p class="admin-nav-section" @if(!$loop->first) style="margin-top: 16px" @endif>{{ $section }}</p>
            @foreach($links as $link)
                <a href="{{ route($link['route']) }}"
                   class="admin-nav-link {{ request()->routeIs($link['active']) ? 'active' : '' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
        @endforeach

        @can('manage_layout')
            <p class="admin-nav-section" style="margin-top: 16px">Hub Pages</p>
            @foreach(config('editorial_layout.hub_slugs', []) as $hubSlug)
                <a href="{{ route('admin.layout.hub', $hubSlug) }}"
                   class="admin-nav-link {{ request()->routeIs('admin.layout.hub') && request()->route('hubSlug') === $hubSlug ? 'active' : '' }}">
                    {{ ucwords(str_replace('-', ' ', $hubSlug)) }}
                </a>
            @endforeach
        @endcan
    </nav>

    <div class="admin-sidebar-footer">
        <p style="margin: 0 0 8px; color: var(--on-dark-muted);">{{ $user->name }} · {{ $user->roleLabel() }}</p>
        <p style="margin: 0 0 8px; color: var(--on-dark-muted);">{{ $user->email }}</p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-ghost btn-sm" style="color: var(--on-dark-muted); padding-left: 0;">Sign out</button>
        </form>
    </div>
</aside>
