<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

interface FileUploadService
{
    public function storeFile(string $folderName, UploadedFile $file);
}
