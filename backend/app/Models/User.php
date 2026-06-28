<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'is_active'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function roleEnum(): UserRole
    {
        return UserRole::tryFrom($this->role) ?? UserRole::Writer;
    }

    public function roleLabel(): string
    {
        return $this->roleEnum()->label();
    }

    public function isEditor(): bool
    {
        return $this->role === UserRole::Editor->value;
    }

    public function isWriter(): bool
    {
        return $this->role === UserRole::Writer->value;
    }

    public function isStaff(): bool
    {
        return in_array($this->role, UserRole::values(), true);
    }

    /** @return list<string> */
    public function permissions(): array
    {
        return config('permissions.'.$this->role, []);
    }

    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions(), true);
    }

    public function canManageUsers(): bool
    {
        return $this->hasPermission('manage_staff');
    }

    public function canManageTaxonomy(): bool
    {
        return $this->hasPermission('manage_categories') || $this->hasPermission('manage_tags');
    }

    public function canManageLayout(): bool
    {
        return $this->hasPermission('manage_layout');
    }

    public function canEditPost(Post $post): bool
    {
        if ($this->isEditor()) {
            return true;
        }

        return $this->isWriter() && $post->user_id === $this->id;
    }
}
