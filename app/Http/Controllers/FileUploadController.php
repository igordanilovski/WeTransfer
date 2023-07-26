<?php

namespace App\Http\Controllers;

use App\Models\FileName;
use App\Repositories\LinkModelRepository;
use App\Services\FileUploadService;
use App\Services\LinkService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    private FileUploadService $fileUploadService;
    private LinkModelRepository $linkModelRepository; //Znam deka e tupo vaka repository u controller i ako tolku ti smeta kazi ke napraam service
    private LinkService $linkService;

    public function __construct(FileUploadService $fileUploadService, LinkModelRepository $linkModelRepository, \App\Services\LinkService $linkService)
    {
        $this->fileUploadService = $fileUploadService;
        $this->linkModelRepository = $linkModelRepository;
        $this->linkService = $linkService;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('file-upload');
    }

    public function store(Request $request): JsonResponse
    {
        if ($request->hasFile('files')) {

            $linkModel = $this->linkModelRepository->store();

            $filesToUpload = $request->file('files');
            //dd($filesToUpload);
            foreach ($filesToUpload as $fileToUpload) {
                if (!$this->fileUploadService->storeFile("test", $fileToUpload, $linkModel)) {
                    return response()->json(['message' => 'No file found.'], 400);
                }
            }

            //TODO: [Bojan->Igor] Ne go cepkaj pri kraj sum so toa od komentiranoto ama nemav vreme da dovrsam poso ke me cekase vo Kapri :))
            return response()->json(['message' => $linkModel->slug], 200);
            //return response()->json(['message' => $this->linkService->getFilesBySlug($linkModel->slug)], 200);
        }
        return response()->json(['message' => 'No file found.'], 400);



    }
}
