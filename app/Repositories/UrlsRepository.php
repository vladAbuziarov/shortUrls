<?php

declare(strict_types=1);
namespace App\Repositories;


use App\Models\Url;

class UrlsRepository implements  \App\Repositories\Interfaces\UrlsRepository
{

    public function addShortUrl(string $url, string $shortUrl): string
    {
       return Url::query()->firstOrCreate([
            "url" => $url,
        ], [
            "url" => $url,
            "hash" => $shortUrl
        ])->hash;
    }

    public function getUrlByHash(string $hash): string
    {
        $url = Url::query()->where("hash", "=", $hash)->firstOrFail();
        return $url->url;
    }
}
