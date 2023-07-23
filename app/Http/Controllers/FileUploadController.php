<?php

namespace App\Http\Controllers;

use App\Services\FileUploadService;
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
    public function create()
    {
        return view('file-upload');
    }

    public function store(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            if ($this->fileUploadService->storeFile("test", $file)) { //TODO: After finishing the upload for each file there should be a record in the DB with the original name, hashed name, generated random link, password protected (boolean - premium API), opened at
                return response()->json(['message' => 'File uploaded successfully.']);
            };
        }

        return response()->json(['message' => 'No file found.'], 400);
    }
}
