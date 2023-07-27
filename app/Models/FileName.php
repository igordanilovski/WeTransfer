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
     * @param string $folder
     */
    public function __construct(UploadedFile $file = null, string $folder = null)
    {
        if($file != null && $folder != null){
            $this->originalName = $file->getClientOriginalName();
            $this->hashName = $file->hashName();
            $this->extension = $file->extension();
            $this->folder = $folder;
        }
        else{
            $this->originalName = "default";
            $this->hashName = "default";
            $this->extension = "default";
            $this->folder = "default";
        }
    }

    public function populateProperties(FileModel $model)
    {
        $this->originalName = $model->original_name;
        $this->hashName = $model->hashed_name;
        $this->extension = $model->extension;
        $this->folder = $model->folder;
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

    /**
     * @param string $originalName
     */
    public function setOriginalName(string $originalName): void
    {
        $this->originalName = $originalName;
    }

    /**
     * @param string $hashName
     */
    public function setHashName(string $hashName): void
    {
        $this->hashName = $hashName;
    }

    /**
     * @param string $extension
     */
    public function setExtension(string $extension): void
    {
        $this->extension = $extension;
    }

    /**
     * @param string $folder
     */
    public function setFolder(string $folder): void
    {
        $this->folder = $folder;
    }


}
