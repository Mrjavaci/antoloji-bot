<?php

namespace App\Enums;

enum HistoryTpyes
{
    case MAIN_SITEMAP;
    case SUB_SITEMAP;
    case POEM_NAME;

    public function value(): string
    {
        return match ($this) {
            self::MAIN_SITEMAP => 1,
            self::SUB_SITEMAP => 2,
            self::POEM_NAME => 3,
        };
    }
}
