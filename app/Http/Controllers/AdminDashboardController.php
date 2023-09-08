<?php

namespace App\Http\Controllers;

use App\Services\LinkService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class AdminDashboardController extends Controller
{
    private LinkService $linkService;

    public function __construct(LinkService $linkService)
    {

        $this->linkService = $linkService;
    }

    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $links = $this->linkService->getLinksByLoggedUser();

        return view("admin-dashboard", ["links" => $links]);
    }
}
