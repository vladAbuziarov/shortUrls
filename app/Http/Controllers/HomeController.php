<?php

declare(strict_types=1);
namespace App\Http\Controllers;


use App\Repositories\Interfaces\UrlsRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    public function __construct(private UrlsRepository $urlsRepository)
    {}

    public function index(): Renderable
    {
        return view("welcome");
    }

    public function redirectToOrigin(string $link): RedirectResponse{
        $array = explode("/", $link);
        $hash = array_pop($array);
        $originUrl = $this->urlsRepository->getUrlByHash($hash);
        return redirect($originUrl);
    }
}
