<?php

namespace App\Contracts;

interface ParseInterface
{
    public function __construct($data);

    public function parse();
}
