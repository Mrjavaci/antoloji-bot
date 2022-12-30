<?php

namespace App\Jobs\Insert;

use App\Jobs\Parse\PoemParse;
use App\Models\Poems;

class InsertPoemJob
{
    public function __construct(private PoemParse $data)
    {
    }

    public function insert()
    {
        return Poems::query()->create([
            'title' => $this->data->getTitle(),
            'body' => $this->data->getBody(),
            'writer' => $this->data->getWriter()
        ]);
    }
}
