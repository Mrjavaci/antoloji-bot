<?php

namespace App\Enums;

enum DatabaseTypes
{
    case MySQL;
    case JSON;

    public function value(): string
    {
        return match ($this) {
            self::MySQL => 'mysql',
            self::JSON => 'json',
        };
    }
}
