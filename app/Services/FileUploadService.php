<?php

namespace App\Services;

use App\Models\LinkModel;
use DateTime;
use Illuminate\Http\UploadedFile;

interface FileUploadService
{
    public function storeFile(string $folderName, UploadedFile $file, LinkModel $linkModel);
}
