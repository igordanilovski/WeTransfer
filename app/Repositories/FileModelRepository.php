<?php

namespace App\Repositories;

use App\Models\FileModel;
use App\Models\FileName;
use App\Models\LinkModel;

class FileModelRepository
{

    public function store(FileName $fileName, LinkModel $linkModel)
    {
        $fileToSave = new FileModel();

        $fileToSave->original_name = $fileName->getOriginalName();
        $fileToSave->hashed_name = $fileName->getHashName();
        $fileToSave->extension = $fileName->getExtension();
        $fileToSave->folder = $fileName->getFolder();

        $fileToSave->link()->associate($linkModel);

        return $fileToSave->save();
    }

    public function getFilesByLinkId($linkId)
    {
        return FileModel::all()
            ->where("link_id", $linkId);
    }

}
