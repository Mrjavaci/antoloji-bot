<?php

namespace App\Jobs\PoemJobs\Database;

use App\Models\Poems;
use Illuminate\Foundation\Bus\Dispatchable;

class SearchPoem
{
    use Dispatchable;

    public function __construct(private $query)
    {

    }

    public function handle()
    {
        return Poems::query()->where('poem', 'LIKE', '%' . $this->query . '%')->groupBy('id', 'title');
    }
}
