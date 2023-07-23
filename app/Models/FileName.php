<?php

namespace App\Models;

use Illuminate\Http\UploadedFile;

class FileName
{
    private string $originalName;
    private string $hashName;
    private string $extension;

    /**
     * @param UploadedFile $file
     */
    public function __construct(UploadedFile $file)
    {
        $this->originalName = $file->getClientOriginalName();
        $this->hashName = $file->hashName();
        $this->extension = $file->extension();
    }

    /**
     * @return array
     */
    public function getAllNamesAsArray(): array
    {
        return [
            'originalName' => $this->originalName,
            'hashName' => $this->hashName,
            'extension' => $this->extension,
        ];
    }
}
