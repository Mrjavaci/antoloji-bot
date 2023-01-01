<?php

namespace App\Jobs\History;

use App\Enums\HistoryTypes;
use Illuminate\Support\Facades\Storage;

class HistoryGetCurrent
{
    public static function getCurrent(HistoryTypes $type)
    {
        return json_decode(Storage::get(HistorySaveJob::FILE_NAME) ?? '{}', 1)[$type->value()] ?? null;
    }

}
