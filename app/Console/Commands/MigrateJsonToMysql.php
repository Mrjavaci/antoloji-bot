<?php

namespace App\Console\Commands;

use App\Services\Database\Migrations\MigrateJsonToMysqlService;
use Illuminate\Console\Command;

class MigrateJsonToMysql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Json To Mysql';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            (new MigrateJsonToMysqlService())
                ->setCommand($this)
                ->execute();
        } catch (\JsonException $e) {
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }
}
