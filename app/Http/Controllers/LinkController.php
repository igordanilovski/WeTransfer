<?php

namespace App\Http\Controllers;

use App\Services\LinkService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;

class LinkController extends Controller
{
    private LinkService $linkService;

    public function __construct(LinkService $linkService)
    {
        $this->linkService = $linkService;
    }

    /**
     * @param $slug
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function findBySlug($slug): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $files = $this->linkService->getFilesBySlug($slug);

        //TODO: [Bojan -> Igor] Use the files however u like in the view
        return view('link-get', ["result" => $files, "slug" => $slug]);
    }

    public function download($slug): Response
    {
        $zipContents = $this->linkService->downloadFilesBySlug($slug);

        $response = new Response($zipContents);
        $response->header('Content-Type', 'application/zip');
        $response->header('Content-Disposition', 'attachment; filename="downloaded-folder.zip"');

        return $response;
    }
}
