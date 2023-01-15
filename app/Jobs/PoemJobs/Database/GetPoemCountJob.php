<?php

namespace App\Jobs\PoemJobs\Database;

use App\Models\Poems;
use Illuminate\Foundation\Bus\Dispatchable;

class GetPoemCountJob
{
    use Dispatchable;

    public function handle()
    {
        return Poems::query()->count();
    }
}
