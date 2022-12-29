<?php

namespace App\Console\Commands;

use App\Services\AntolojiFetchService;
use Illuminate\Console\Command;

class AntolojiFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'antoloji:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch all poems';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return (new AntolojiFetchService($this))->fetch();
    }
}
