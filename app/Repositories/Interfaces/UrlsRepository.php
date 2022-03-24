<?php

declare(strict_types=1);
namespace App\Repositories\Interfaces;


interface UrlsRepository
{
    public function addShortUrl(string $url, string $shortUrl): string;

    public function getUrlByHash(string $hash): string;
}
