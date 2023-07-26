<?php

namespace App\Repositories;

use App\Models\LinkModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LinkModelRepository
{


    /**
     * @return LinkModel|null
     */
    public function store(): ?LinkModel
    {
        $linkToSave = new LinkModel();

        $slug = $this->generateRandomSlug(5);

        while ($this->findBySlug($slug) != null){
            $slug = $this->generateRandomSlug(5);
        }

        $linkToSave->slug = $slug;

        $linkToSave->save();

        return $linkToSave->fresh();
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
            return LinkModel::where('slug', $slug)->firstOrFail();
        } catch (ModelNotFoundException $exception){
            return null;
        }
    }
}
