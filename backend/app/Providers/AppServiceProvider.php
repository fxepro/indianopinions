<?php

namespace App\Providers;

use App\Enums\Permission;
use App\Models\Post;
use App\Policies\PostPolicy;
use App\Support\AppUrl;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Post::class, PostPolicy::class);

        foreach (Permission::cases() as $permission) {
            Gate::define($permission->value, fn ($user) => $user->hasPermission($permission->value));
        }

        \Illuminate\Support\Facades\Route::bind('post', function (string $value) {
            $query = Post::query();

            if (ctype_digit($value)) {
                $query->whereKey((int) $value);
            } else {
                $query->where('slug', $value);
            }

            return $query->firstOrFail();
        });

        if ($this->app->environment('production')) {
            URL::forceScheme('https');

            if (! $this->app->runningInConsole()) {
                $request = request();
                $forwardedHost = $request->header('X-Forwarded-Host');
                $host = is_string($forwardedHost) && $forwardedHost !== ''
                    ? strtolower(trim(explode(',', $forwardedHost)[0]))
                    : null;

                $allowedHosts = AppUrl::allAllowedHosts(
                    (string) env('APP_URL'),
                    env('APP_ALLOWED_HOSTS')
                );

                if ($host !== null && in_array($host, $allowedHosts, true)) {
                    URL::forceRootUrl('https://'.$host);
                } else {
                    URL::forceRootUrl(config('app.url'));
                }
            }
        }
    }
}
