<?php

namespace App\Repositories;

use App\Models\LinkModel;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LinkModelRepository
{
    private const slugSize = 5;

    /**
     * @param $expirationDate
     * @param $isUserLoggedIn
     * @param $user
     * @return LinkModel|null
     */
    public function store($expirationDate, $isUserLoggedIn, $user): ?LinkModel
    {
        $linkToSave = new LinkModel();
        $linkToSave->time_opened = 0;

        $slug = $this->generateRandomSlug();

        while ($this->findBySlug($slug) != null){
            $slug = $this->generateRandomSlug();
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

            $linkToSave->user()->associate($user);
        }

        $linkToSave->save();

        return $linkToSave->fresh();
    }

    /**
     * @param $link
     * @return void
     */
    public function incrementTimeOpened($link): void
    {
        $link->time_opened ++;
        $link->update();
    }

    /**
     * @return string
     */
    private function generateRandomSlug(): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $slug = '';
        $charLength = strlen($characters);

        for ($i = 0; $i < self::slugSize; $i++) {
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

    /**
     * @param $userId
     * @return null
     */
    public function findByUser($userId)
    {
        try {
            return LinkModel::all()->where('user_id', $userId);
        } catch (ModelNotFoundException $exception){
            return null;
        }
    }
}
