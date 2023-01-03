<?php

namespace App\Jobs\Fetch;

use App\Contracts\FetchInterface;
use App\Enums\HistoryTypes;
use App\Jobs\History\HistorySaveJob;
use App\Jobs\Parse\PoemParse;
use Exception;
use Illuminate\Support\Facades\Http;

class FetchSite implements FetchInterface
{
    private $data;

    public function setUrl($url): self
    {
        $this->url = $url;
        return $this;
    }

    public function fetch(): self
    {
        try {
            $this->setData(Http::get($this->getUrl())->body());
        } catch (Exception $exception) {
            (new HistorySaveJob())
                ->setOperationKey(HistoryTypes::LAST_ERROR_LOG)
                ->setValue($exception->getMessage())
                ->save();
            $this->fetch();
        }
        return $this;
    }

    public function getUrl()
    {
        return $this->url;
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
