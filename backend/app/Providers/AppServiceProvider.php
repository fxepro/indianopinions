<?php

namespace App\Providers;

use App\Enums\Permission;
use App\Models\Post;
use App\Policies\PostPolicy;
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
        }
    }
}
