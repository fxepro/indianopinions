<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Indian Opinions</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-shell">
<div class="admin-layout">
    @include('partials.admin.sidebar')

    <div class="admin-main">
        <header class="admin-topbar">
            <div>
                <p class="admin-topbar-title">@yield('page_title', 'Editorial Console')</p>
            </div>
            <div class="admin-topbar-meta">
                <span class="badge badge-primary">{{ auth()->user()->roleLabel() }}</span>
                <span>{{ auth()->user()->name }}</span>
                @if($frontend = config('app.frontend_url'))
                    <a href="{{ $frontend }}" target="_blank" class="link">View site</a>
                @endif
            </div>
        </header>

        <main class="admin-content">
            @include('partials.admin.alerts')
            @yield('content')
        </main>
    </div>
</div>
@stack('scripts')
</body>
</html>
