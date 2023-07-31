<?php

namespace App\Http\Controllers;

use App\Services\LinkService;

class LinkController extends Controller
{
    private LinkService $linkService;

    public function __construct(LinkService $linkService)
    {
        $this->linkService = $linkService;
    }

    public function findBySlug($slug)
    {
        $files = $this->linkService->getFilesBySlug($slug);

        //TODO: [Bojan -> Igor] Use the files however u like in the view
        return view('link-get', ["files" => $files]);
    }

}
