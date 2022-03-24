<?php

declare(strict_types=1);

namespace App\Services;


use App\Repositories\Interfaces\UrlsRepository;
use App\Services\Interfaces\UrlChecker;

class UrlCreator implements \App\Services\Interfaces\UrlCreator
{

    const DEFAULT_STRING_LENGTH = 6;

    public function __construct(
        private UrlChecker $checker,
        private UrlsRepository $urlsRepository
    )
    {
    }

    public function createShortUrl(string $url, ?int $length = self::DEFAULT_STRING_LENGTH): string
    {
        $this->checker->checkIsUrlAvailable($url);
        if (!$this->checker->CheckUrl($url)) {
            throw new \RuntimeException("Url is unsafe!", 422);
        }
        $shortUrl = $this->urlsRepository->addShortUrl($url, $this->generateHash($url, $length));
        return url('/') . "/" . $shortUrl;
    }

    private function generateHash(string $fromString, int $length): string
    {
        return substr(md5(now()->toIso8601String()), 0, $length);
    }
}
