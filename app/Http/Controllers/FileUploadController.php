<?php

namespace App\Http\Controllers;

use App\Models\FileName;
use App\Repositories\LinkModelRepository;
use App\Services\FileUploadService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    private FileUploadService $fileUploadService;
    private LinkModelRepository $linkModelRepository;

    public function __construct(FileUploadService $fileUploadService, LinkModelRepository $linkModelRepository)
    {
        $this->fileUploadService = $fileUploadService;
        $this->linkModelRepository = $linkModelRepository;
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
                if ($this->fileUploadService->storeFile("test", $fileToUpload, $linkModel)) {
                    $fileNameObj = new FileName($fileToUpload, "test"); //TODO: Sredi go ova da ide od funkcijava gadno e vaka
                    //TODO: [Igor->Bojan] Well, this is shitty a little bit. Leave it to me i will find a way.
                    //return response()->json(['message' => $fileNameObj->getAllNamesAsArray()], 200);
                }
            }
        }

        return response()->json(['message' => 'No file found.'], 400);
    }
}
