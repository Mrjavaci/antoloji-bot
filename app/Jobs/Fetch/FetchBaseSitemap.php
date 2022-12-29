<?php

namespace App\Jobs\Fetch;

use App\Contracts\FetchInterface;
use App\Jobs\Parse\BaseSitemapParse;
use Exception;
use Illuminate\Support\Facades\Http;

class FetchBaseSitemap implements FetchInterface
{
    private $data;

    public function __construct(private $url = null)
    {
        !is_null($this->getUrl()) ?: $this->setUrl(config('antoloji.base.xml'));
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
        $this->setData((new BaseSitemapParse($this->getData()))->parse()->getData());
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
