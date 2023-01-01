<?php

namespace App\Contracts;

interface FetchInterface
{
    public function __construct($url = null);

    public function fetch();

    public function parse();

}
