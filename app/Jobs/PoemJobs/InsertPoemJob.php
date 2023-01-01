<?php

namespace App\Jobs\PoemJobs;

use App\Jobs\Parse\PoemParse;
use App\Models\Poems;
use Illuminate\Support\Facades\Storage;

class InsertPoemJob
{
    public const FILE_NAME = 'poems.json';

    public function __construct(private PoemParse $data)
    {
    }

    public function insert()
    {
        $serializedData = [
            'title' => $this->data->getTitle(),
            'body' => $this->data->getBody(),
            'writer' => $this->data->getWriter()
        ];
        if (config('antoloji.saveAsJson')) {
            $json = json_decode(Storage::get(self::FILE_NAME) ?? "{}", true);
            $json[] = $serializedData;
            Storage::disk()->put(self::FILE_NAME, json_encode($json));
        }
        if (config('antoloji.saveAsDatabase')) {
            Poems::query()->create($serializedData);
        }
        return collect($serializedData);
    }
}
