<?php

namespace App\Services;

use App\Jobs\Fetch\FetchBaseSitemap;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class AntolojiFetchService
{
    public function __construct(public Command $commandInterface)
    {

    }

    public function fetch(): int
    {
        try {
            $baseSitemap = (new FetchBaseSitemap())
                ->fetch()
                ->parse()
                ->getData();

            dd($baseSitemap);
        } catch (\Exception $e) {
        }


        return CommandAlias::SUCCESS;
    }
}
