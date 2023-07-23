<?php

namespace App\Http\Controllers;

use App\Models\FileName;
use App\Services\FileUploadService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    private FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
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
        if ($request->hasFile('file')) {
            $fileToUpload = $request->file('file');

            if ($this->fileUploadService->storeFile("test", $fileToUpload)) {
                $fileNameObj = new FileName($fileToUpload, "test"); //TODO: Sredi go ova da ide od funkcijava gadno e vaka
                return response()->json(['message' => $fileNameObj->getAllNamesAsArray()], 200);
            }
        }

        return response()->json(['message' => 'No file found.'], 400);
    }
}
