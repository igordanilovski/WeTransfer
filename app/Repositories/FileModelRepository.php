<?php

namespace App\Repositories;

use App\Models\FileModel;
use App\Models\FileName;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FileModelRepository
{

    public function store(FileName $fileName)
    {
        $fileToSave = new FileModel();


        $fileToSave->original_name = $fileName->getOriginalName();
        $fileToSave->hashed_name = $fileName->getHashName();
        $fileToSave->extension = $fileName->getExtension();
        $fileToSave->folder = $fileName->getFolder();

        $slug = $this->generateRandomSlug(5);

        while ($this->findBySlug($slug) != null){
            $slug = $this->generateRandomSlug(5);
        }

        $fileToSave->slug = $slug;

        return $fileToSave->save();
    }

    private function generateRandomSlug($length) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $slug = '';
        $charLength = strlen($characters);

        for ($i = 0; $i < $length; $i++) {
            $slug .= $characters[rand(0, $charLength - 1)];
        }

        return $slug;
    }

    /**
     * @param $slug
     * @return null
     */
    public function findBySlug($slug)
    {
        try {
            return FileModel::where('slug', $slug)->firstOrFail();
        } catch (ModelNotFoundException $exception){
            return null;
        }
    }

}
