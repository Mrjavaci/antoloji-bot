<?php

namespace App\Jobs\PoemJobs\Database;

use App\Models\Poems;
use Illuminate\Foundation\Bus\Dispatchable;

class GetRandomPoemJob
{
    use Dispatchable;

    public function handle()
    {
        return Poems::query()->limit(1)->inRandomOrder()->first();
    }
}
