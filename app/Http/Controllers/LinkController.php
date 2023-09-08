<?php

namespace App\Http\Controllers;

use App\Services\LinkService;
use DateTime;
use Exception;
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
     * @throws Exception
     */
    public function findBySlug($slug): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        if(!$this->checkLinkAccessibility($slug)){
            return view('link-get', ["slug" => $slug, "accessible" => false]);
        }

        $files = $this->linkService->getFilesBySlug($slug);
        $this->linkService->openLink($slug);

        return view('link-get', ["result" => $files, "slug" => $slug, "accessible" => true]);
    }

    public function download($slug): Response
    {
        $zipContents = $this->linkService->downloadFilesBySlug($slug);

        $response = new Response($zipContents);
        $response->header('Content-Type', 'application/zip');
        $response->header('Content-Disposition', 'attachment; filename="downloaded-folder.zip"');

        return $response;
    }

    /**
     * @param $slug
     * @return bool
     * @throws Exception
     */
    private function checkLinkAccessibility($slug): bool
    {
        $link = $this->linkService->getLinkBySlug($slug);

        if ($link == null)
            return false;

        if(!$link->has_expiration){
            return true; //If the link doesn't have an expiration it means its accessible indefinitely
        }
        else{
            $today = new DateTime();
            $linkDate = new DateTime($link->expiration_date);

            if ($today <= $linkDate){
                return true;
            }
            return false;
        }
    }
}
