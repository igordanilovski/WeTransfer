<?php

namespace App\Services\Implementation;

use App\Models\FileName;
use App\Repositories\FileModelRepository;
use App\Services\FileUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadServiceImplementation implements FileUploadService
{
    private readonly FileModelRepository $fileModelRepository;

    public function __construct(FileModelRepository $fileModelRepository)
    {
        $this->fileModelRepository = $fileModelRepository;
    }

    /**
     * Uploading files to AWS S3 Bucket
     * @param string $folderName Folder name where filed should be stored
     * @param UploadedFile $file
     * @return bool Returns boolean if file is successfully stored or not.
     */
    public function storeFile(string $folderName, UploadedFile $file): bool
    {
        $storagePutFile = Storage::disk("s3")->putFile($folderName, $file);

        if (!$storagePutFile) {
            return false;
        }

        $fileNameObj = new FileName($file, $folderName);
        $this->fileModelRepository->store($fileNameObj);

        return true;
    }
}
