<?php

namespace App\Enums;

enum PostStatus: string
{
    case Draft = 'draft';
    case Submitted = 'submitted';
    case InReview = 'in_review';
    case ChangesRequested = 'changes_requested';
    case Published = 'published';
    case Rejected = 'rejected';
    case Archived = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Submitted => 'Submitted',
            self::InReview => 'In Review',
            self::ChangesRequested => 'Changes Requested',
            self::Published => 'Published',
            self::Rejected => 'Rejected',
            self::Archived => 'Archived',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Draft => 'badge-muted',
            self::Submitted => 'badge-info',
            self::InReview => 'badge-info',
            self::ChangesRequested => 'badge-warning',
            self::Published => 'badge-success',
            self::Rejected => 'badge-danger',
            self::Archived => 'badge-muted',
        };
    }

    public function isPublic(): bool
    {
        return $this === self::Published;
    }

    /** @return list<string> */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
