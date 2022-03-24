<?php

declare(strict_types=1);

namespace App\Services;


use App\Exceptions\EmptyConfigException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class GoogleApiUrlChecker implements \App\Services\Interfaces\UrlChecker
{
    private const BASE_URL = "https://safebrowsing.googleapis.com/v4/";
    private const THREAT_MATCHES_ENDPOINT = "threatMatches:find";
    private const SAFE_BROWSING_API_KEY_CONFIG_PATH = "services.google-safe-browsing.apiKey";

    public function __construct(private Client $client)
    {
    }

    public function checkUrl(string $url): bool
    {
        try {
            $apiUrl = $this->prepareApiUrl(self::THREAT_MATCHES_ENDPOINT);
            $response = $this->client->post($apiUrl, $this->prepareRequestBody($url));
            return empty(json_decode($response->getBody()->getContents())->matches);
        } catch (GuzzleException $e) {
            Log::error("can't send request to api: ", [
                "message" => $e->getMessage(),
                "trace" => $e->getTrace()
            ]);
            throw new \RuntimeException("Server side error", 500);
        }

    }

    public function checkIsUrlAvailable(string $url): bool
    {
        try {
            return $this->client->get(
                    $url, ['connect_timeout' => 5.00]
                )->getStatusCode() == 200;
        } catch (GuzzleException $e) {
            Log::info("Failed to call given url: " . $url,
                ["message" => $e->getMessage(), "trace" => $e->getTrace()]);
            throw new \RuntimeException("Sorry, your url is not available. Please try other link...", 422);
        }

    }

    private function prepareApiUrl(string $endpoint): string
    {
        $apiKey = config(self::SAFE_BROWSING_API_KEY_CONFIG_PATH, null);
        if (empty($apiKey)) {
            Log::error("Safe Browsing api key should not be empty!");
            throw new EmptyConfigException("server side error", 500);
        }
        return self::BASE_URL . $endpoint . "?key=" . $apiKey;
    }

    private function prepareRequestBody(string $urlToCheck): array
    {
        return [
            "json" => [
                "client" => [
                    "clientId" => env('APP_NAME', 'Laravel'),
                    "clientVersion" => "1.5.2"
                ],
                "threatInfo" => [
                    "threatTypes" => ["MALWARE", "SOCIAL_ENGINEERING"],
                    "platformTypes" => ["WINDOWS", "LINUX"],
                    "threatEntryTypes" => ["URL"],
                    "threatEntries" => [
                        ["url" => $urlToCheck]
                    ]
                ]
            ]
        ];
    }
}
