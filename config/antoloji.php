<?php

use App\Enums\DatabaseTypes;

return [
    /*
    |--------------------------------------------------------------------------
    | ANTOLOJİ.COM'un tüm şiirlerinin olduğu sitemap dosyası
    |--------------------------------------------------------------------------
    */
    'base' => [
        'xml' => 'https://www.antoloji.com/sitemap/tumsiirler/'
    ],
    /*
    |--------------------------------------------------------------------------
    | ANTOLOJİ.COM üyesi olan şiirleri kaydet
    |--------------------------------------------------------------------------
    */
    'fetchOwnPoemOfUser' => true,
    /*
    |--------------------------------------------------------------------------
    | ANTOLOJİ.COM'da taratılan şiirlerin json dosyasına kaydedilmesi
    |--------------------------------------------------------------------------
    */
    'saveAsJson' => true,
    /*
    |--------------------------------------------------------------------------
    | ANTOLOJİ.COM'da taratılan şiirlerin database'e kaydedilmesi
    |--------------------------------------------------------------------------
    */
    'saveAsDatabase' => true,
    /*
    |--------------------------------------------------------------------------
    | Web sunucusunun varsayılan db'si (mysql - json)
    |--------------------------------------------------------------------------
    */
    'defaultDatabase' => DatabaseTypes::MySQL


];
