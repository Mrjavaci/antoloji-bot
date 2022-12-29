<?php

namespace App\Jobs\Parse;

use App\Contracts\ParseInterface;
use Exception;

class BaseSitemapParse implements ParseInterface
{

    /**
     * @throws Exception
     */
    public function __construct(private $data)
    {
        !is_null($this->getData()) ?: throw new \Exception('Null Data');
    }

    public function getData()
    {
        return $this->data;
    }

    public function parse(): self
    {
        $this->setData(json_decode(json_encode(simplexml_load_string($this->getData()))));
        $this->setData(collect($this->getData()->sitemap));
        return $this;
    }

    public function setData($data): void
    {
        $this->data = $data;
    }
}
