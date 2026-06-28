<?php

namespace App\Enums;

enum UserRole: string
{
    case Editor = 'editor';
    case Writer = 'writer';

    public function label(): string
    {
        return match ($this) {
            self::Editor => 'Editor',
            self::Writer => 'Writer',
        };
    }

    /** @return list<string> */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
