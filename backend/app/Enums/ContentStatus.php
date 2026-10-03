<?php

namespace App\Enums;

enum ContentStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
    case Archived = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::Draft => __('admin.status.draft'),
            self::Published => __('admin.status.published'),
            self::Archived => __('admin.status.archived'),
        };
    }
}
