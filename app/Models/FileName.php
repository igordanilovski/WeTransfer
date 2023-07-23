<?php

namespace App\Models;

use Illuminate\Http\UploadedFile;

class FileName
{
    private string $originalName;
    private string $hashName;
    private string $extension;
    private string $folder;

    /**
     * @param UploadedFile $file
     */
    public function __construct(UploadedFile $file, string $folder)
    {
        $this->originalName = $file->getClientOriginalName();
        $this->hashName = $file->hashName();
        $this->extension = $file->extension();
        $this->folder = $folder;
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

    /**
     * @return string
     */
    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    /**
     * @return string
     */
    public function getHashName(): string
    {
        return $this->hashName;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @return string
     */
    public function getFolder(): string
    {
        return $this->folder;
    }


}
