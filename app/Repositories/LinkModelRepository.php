<?php

namespace App\Repositories;

use App\Models\LinkModel;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LinkModelRepository
{


    /**
     * @return LinkModel|null
     */
    public function store($expirationDate, $isUserLoggedIn): ?LinkModel
    {
        $linkToSave = new LinkModel();

        $slug = $this->generateRandomSlug(5);

        while ($this->findBySlug($slug) != null){
            $slug = $this->generateRandomSlug(5);
        }

        $today = new DateTime();
        $newDate = $today->modify('+7 days');
        $linkToSave->slug = $slug;

        if ($isUserLoggedIn == false){
            $linkToSave->expiration_date = $newDate; //Set the expiration date to 7 days
            $linkToSave->has_expiration = 1;
        }
        else{
            if ($expirationDate == null){
                $linkToSave->has_expiration = 0; //The link lifecycle is infinite
            }
            else{
                $linkToSave->expiration_date = $expirationDate;
                $linkToSave->has_expiration = 1;
            }
        }

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
