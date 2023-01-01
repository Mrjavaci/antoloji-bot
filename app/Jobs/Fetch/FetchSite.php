<?php

namespace App\Jobs\Fetch;

use App\Contracts\FetchInterface;
use App\Enums\HistoryTypes;
use App\Jobs\History\HistorySaveJob;
use App\Jobs\Parse\PoemParse;
use Exception;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Queue\Jobs\SyncJob;
use Illuminate\Support\Facades\Http;

class FetchSite extends SyncJob implements FetchInterface
{
    private $data;

    public function __construct(private $url = null)
    {
        !is_null($this->getUrl()) ?: throw new Exception('Site url should not null');
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url): void
    {
        $this->url = $url;
    }

    public function fetch(): self
    {
        $this->setData(Http::get($this->getUrl())->body());
        return $this;
    }

    /**
     * @throws Exception
     */
    public function parse(): self
    {
        $this->setData((new PoemParse($this->getData()))->parse());
        (new HistorySaveJob())
            ->setOperationKey(HistoryTypes::POEM_NAME)
            ->setValue($this->getData()->getTitle())
            ->save();
        (new HistorySaveJob())
            ->setOperationKey(HistoryTypes::POEM_WRITER)
            ->setValue($this->getData()->getWriter())
            ->save();
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data): void
    {
        $this->data = $data;
    }
}
