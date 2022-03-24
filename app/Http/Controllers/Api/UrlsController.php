<?php
declare(strict_types=1);


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\CreateShortUrlRequest;
use App\Services\Interfaces\UrlCreator;
use Illuminate\Http\JsonResponse;

class UrlsController extends  Controller
{
    public function __construct(private UrlCreator $urlCreator)
    {}

    public function create(CreateShortUrlRequest $request): JsonResponse{
        try {
            $shortUrl = $this->urlCreator->createShortUrl($request->get("url"));
            return response()->json(compact('shortUrl'));

        }catch (\Exception $e){
            return response()->json($e->getMessage(), $e->getCode());
        }

    }
}
