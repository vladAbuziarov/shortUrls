<?php

declare(strict_types=1);
namespace App\Services\Interfaces;


interface UrlCreator
{
    public function createShortUrl(string $url, ?int $length = null): string;
}
