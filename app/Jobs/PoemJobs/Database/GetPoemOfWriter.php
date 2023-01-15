<?php

namespace App\Jobs\PoemJobs\Database;

use App\Models\Poems;
use Illuminate\Foundation\Bus\Dispatchable;

class GetPoemOfWriter
{
    use Dispatchable;

    public function __construct(private $parameter, private $by)
    {

    }

    public function handle()
    {
        if ($this->by === 'writerName') {
            return Poems::query()->where('writer', $this->parameter)->paginate();
        } else if ($this->by === 'writerId') {
            /**
             * @todo mrjavaci
             */
            return false;
        }
        return false;
    }
}
