<?php

namespace App\Console\Commands;

use App\Jobs\Insert\InsertPoemJob;
use App\Models\Poems;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class AntolojiCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'antoloji:count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Total database row count';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->warn('Database -> ' . Poems::query()->count());
        } catch (\Exception $exception) {

        }
        $this->warn('Json file -> ' . collect(json_decode(Storage::get(InsertPoemJob::FILE_NAME), 1))->count());
        return Command::SUCCESS;
    }
}
