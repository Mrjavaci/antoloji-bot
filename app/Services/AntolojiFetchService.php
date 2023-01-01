<?php

namespace App\Services;

use App\Enums\HistoryTypes;
use App\Events\PoemCreated;
use App\Jobs\Fetch\FetchBaseSitemap;
use App\Jobs\History\HistoryGetCurrent;
use App\Jobs\History\HistorySaveJob;
use App\Jobs\PoemJobs\DeletePoemJob;
use App\Jobs\ProcessAntoloji;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Symfony\Component\Console\Command\Command as CommandAlias;

class AntolojiFetchService
{
    protected $seekToPoem = null;

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
            $seekToPoem = null;
            if ($historyMainSitemap = HistoryGetCurrent::getCurrent(HistoryTypes::MAIN_SITEMAP)) {
                $baseSitemapCount = $baseSitemap->where('loc', '=', $historyMainSitemap)->toArray();
                $baseSitemap = $baseSitemap->forget($this->getNumbers(array_keys($baseSitemapCount)[0]));
                $this->commandInterface->info('Seek to history -> ' . HistoryGetCurrent::getCurrent(HistoryTypes::POEM_NAME));
                $this->seekToPoem = HistoryGetCurrent::getCurrent(HistoryTypes::SUB_SITEMAP);
            }

            foreach ($baseSitemap as $pageUrl) {
                (new HistorySaveJob())
                    ->setOperationKey(HistoryTypes::MAIN_SITEMAP)
                    ->setValue($pageUrl->loc)
                    ->save();

                /**
                 * @var $subSitemap Collection
                 */
                $subSitemap = (new FetchBaseSitemap($pageUrl->loc))
                    ->fetch()
                    ->parse()
                    ->getData();
                foreach ($subSitemap as $url) {
                    if (!is_null($this->seekToPoem) && $this->seekToPoem !== $url->loc) {
                        //son kapanmadan önce eksik veri girilme ihtimaline karşı son girileni siliyoruz!
                        (new DeletePoemJob(HistoryGetCurrent::getCurrent(HistoryTypes::POEM_NAME), HistoryGetCurrent::getCurrent(HistoryTypes::POEM_WRITER)))->delete();
                        continue;
                    }
                    $this->seekToPoem = null;
                    (new HistorySaveJob())
                        ->setOperationKey(HistoryTypes::SUB_SITEMAP)
                        ->setValue($url->loc)
                        ->save();

                    ProcessAntoloji::dispatch($url->loc);
                }

            }


        } catch (\Exception $e) {
            dd($e);
        }


        return CommandAlias::SUCCESS;
    }

    function getNumbers($number)
    {
        $numbers = array();
        for ($i = 0; $i < $number; $i++) {
            $numbers[] = $i;
        }
        return array_reverse($numbers);
    }

}
