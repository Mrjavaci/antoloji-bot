<?php

namespace App\Jobs;

use App\Events\PoemCreated;
use App\Jobs\Fetch\FetchSite;
use App\Jobs\Insert\InsertPoemJob;
use App\Jobs\Parse\PoemParse;
use App\Models\Poems;
use Illuminate\Bus\Queueable;
use Illuminate\Console\Command;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessAntoloji implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public $url)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {

        /** @var PoemParse $data */
        $data = (new FetchSite($this->url))
            ->fetch()
            ->parse()
            ->getData();
        /** @var Poems $poem */
        $poem = (new InsertPoemJob($data))->insert();
        PoemCreated::dispatch($poem);
    }
}
