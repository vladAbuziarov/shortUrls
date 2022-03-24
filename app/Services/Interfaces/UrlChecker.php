<?php
declare(strict_types=1);

namespace App\Services\Interfaces;


interface UrlChecker
{
    public function checkUrl(string $url): bool;
    public function checkIsUrlAvailable(string $url): bool;
}
