<?php

namespace App\Models;

class FileUploadDTO
{
    public string $link;
    public array $files;

    public function __construct(string $link, array $files)
    {
        $this->link = "http://localhost:8000/link/" . $link;
        $this->files = $files;
    }
}
