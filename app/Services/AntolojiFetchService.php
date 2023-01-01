<?php

namespace App\Services;

use App\Enums\HistoryTpyes;
use App\Events\PoemCreated;
use App\Jobs\Fetch\FetchBaseSitemap;
use App\Jobs\History\HistorySaveJob;
use App\Jobs\ProcessAntoloji;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Symfony\Component\Console\Command\Command as CommandAlias;

class AntolojiFetchService
{
    public function __construct(public Command $commandInterface)
    {

    }

    public function fetch(): int
    {
        try {

            $cli = $this->commandInterface;
            Event::listen(function (PoemCreated $event) use ($cli) {
                $cli->info($event->getPoem()->get('title') . ' Kaydedildi!');
            });

            /**
             * @var $baseSitemap Collection
             */
            $baseSitemap = (new FetchBaseSitemap())
                ->fetch()
                ->parse()
                ->getData();
            $baseSitemap->map(function ($pageUrl) {


                (new HistorySaveJob())
                    ->setOperationKey(HistoryTpyes::MAIN_SITEMAP)
                    ->setValue($pageUrl->loc)
                    ->save();

                /**
                 * @var $subSitemap Collection
                 */
                $subSitemap = (new FetchBaseSitemap($pageUrl->loc))
                    ->fetch()
                    ->parse()
                    ->getData();
                $subSitemap->map(function ($url) {
                    (new HistorySaveJob())
                        ->setOperationKey(HistoryTpyes::SUB_SITEMAP)
                        ->setValue($url->loc)
                        ->save();

                    ProcessAntoloji::dispatch($url->loc);
                });
            });


        } catch (\Exception $e) {
            dd($e);
        }


        return CommandAlias::SUCCESS;
    }
}
