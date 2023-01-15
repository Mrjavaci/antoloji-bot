<?php

namespace App\Services\Database\Migrations;

use App\Jobs\PoemJobs\InsertPoemJob;
use App\Models\Poems;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MigrateJsonToMysqlService
{

    private Command $command;

    public function execute(): bool
    {

        $this->command->info("Operation Is Starting");
        $debug = $this->command->ask("Open debug mode ? y/n");
        if ($debug !== 'y' && $debug !== 'n') {
            $this->command->error("Invalid option");
            return false;
        }
        $json = json_decode(Storage::get(InsertPoemJob::FILE_NAME) ?? '{}', false, 512, JSON_THROW_ON_ERROR);
        foreach ($json as $poem) {
            if ($debug === 'y') {
                $this->command->info($poem->title . ' Migrating');
            }
            Poems::query()->create(['title' => $poem->title, 'body' => $poem->body, 'writer' => $poem->writer]);
        }
        $this->command->info('Migration completed');
        return true;

    }

    public function getCommand()
    {
        return $this->command;
    }

    public function setCommand($command): self
    {
        $this->command = $command;
        return $this;
    }


}
