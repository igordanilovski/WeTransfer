<?php

namespace App\Http\Controllers;

use App\Repositories\LinkModelRepository;
use App\Services\FileUploadService;
use App\Services\LinkService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('file-upload')->with("authenticated", Auth::check());
    }

    public function store(Request $request): JsonResponse
    {
        if ($request->hasFile('files')) {


            $linkModel = $this->linkModelRepository->store($request['expiration-datetime'], Auth::check(), Auth::user());

            $filesToUpload = $request->file('files');
            //dd($filesToUpload);

            if (!$this->validateUploadSize($filesToUpload)) {
                return response()->json(['message' => 'The file/s you upload must be below 25MB.'], 400);
            }

            foreach ($filesToUpload as $fileToUpload) {
                //TODO:Do not create the link if the files aren't stored successfully
                if (!$this->fileUploadService->storeFile("test", $fileToUpload, $linkModel)) {
                    return response()->json(['message' => 'No file found.'], 400);
                }
            }

            $result = $this->linkService->getFilesBySlug($linkModel->slug);
            return response()->json(['message' => $result], 200);
        }
        return response()->json(['message' => 'No file found.'], 400);
    }

    private function validateUploadSize($filesToUpload)
    {
        if (Auth::check()){
            return true;
        }

        $sizeCounterInBytes = 0;

        foreach ($filesToUpload as $fileToUpload) {
            $sizeCounterInBytes += $fileToUpload->getSize();
        }

        $sizeCounterInMB = $sizeCounterInBytes / (1024 * 1024);
        if ($sizeCounterInMB > 25) {
            return false;
        }
        return true;
    }
}
