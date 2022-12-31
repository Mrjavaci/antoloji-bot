<?php

namespace App\Console\Commands;

use App\Models\Poems;
use Illuminate\Console\Command;

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
        $this->warn(Poems::query()->count());
        return Command::SUCCESS;
    }
}
