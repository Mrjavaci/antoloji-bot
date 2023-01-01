<?php

namespace App\Jobs\PoemJobs;

use App\Models\Poems;
use Illuminate\Support\Facades\Storage;

class DeletePoemJob
{

    public function __construct(private $poemTitle, private $poemWriter)
    {
    }

    public function delete()
    {
        if (config('antoloji.saveAsJson')) {
            $json = json_decode(Storage::get(InsertPoemJob::FILE_NAME) ?? "{}", true);
            $json = collect($json);
            if ($needDeleteData = $json->where('title', '=', $this->poemTitle)->where('writer', '=', $this->poemWriter)) {
                $oldJson = $json;
                $json->forget($needDeleteData->keys()->get(0));
            }
            Storage::disk()->put(InsertPoemJob::FILE_NAME, $json->toJson());
        }
        if (config('antoloji.saveAsDatabase')) {
            Poems::query()->where('title', '=', $this->poemTitle)->delete();
        }
    }
}
