<?php

namespace App\Services;

interface LinkService
{
    public function getLinkBySlug(string $slug);

    public function getLinksByLoggedUser();

    public function getFilesBySlug(string $slug);

    public function openLink($slug);

    public function downloadFilesBySlug(string $slug);
}
