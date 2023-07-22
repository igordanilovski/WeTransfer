<?php

namespace App\Services\Implementation;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadServiceImplementation implements \App\Services\FileUploadService
{
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
        return true;
    }
}
