<?php

namespace App\Contracts;

interface FetchInterface
{
    public function __construct($url);

    public function fetch();

    public function parse();

}
