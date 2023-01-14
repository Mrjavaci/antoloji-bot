<?php

namespace App\Services\Database;

use App\Enums\DatabaseTypes;
use App\Models\Poems;
use Dflydev\DotAccessData\Data;
use Illuminate\Foundation\Bus\Dispatchable;

class GetPoemCountService
{
    use Dispatchable;

    public function handle()
    {
        $defaultDatabase = GetDefaultDatabaseService::dispatchSync()->name;
        if ($defaultDatabase === DatabaseTypes::MySQL->name) {
            return Poems::query()->count();
        } else if ($defaultDatabase === DatabaseTypes::JSON->name) {
            /**
             * @todo @mrJavaci
             */
            return false;
        }
    }
}
