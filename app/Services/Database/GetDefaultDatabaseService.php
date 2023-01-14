<?php

namespace App\Services\Database;

use App\Enums\DatabaseTypes;
use Illuminate\Foundation\Bus\Dispatchable;

class GetDefaultDatabaseService
{
    use Dispatchable;

    /**
     * @return DatabaseTypes
     */
    public function handle()
    {
        return config('antoloji.defaultDatabase');
    }
}
