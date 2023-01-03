<?php

namespace App\Enums;

enum HistoryTypes
{
    case MAIN_SITEMAP;
    case SUB_SITEMAP;
    case POEM_NAME;
    case POEM_WRITER;
    case LAST_ERROR_LOG;

    public function value(): string
    {
        return match ($this) {
            self::MAIN_SITEMAP => 1,
            self::SUB_SITEMAP => 2,
            self::POEM_NAME => 3,
            self::POEM_WRITER => 4,
            self::LAST_ERROR_LOG => 5,
        };
    }
}
