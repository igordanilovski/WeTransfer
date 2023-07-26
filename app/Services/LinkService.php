<?php

namespace App\Services;

interface LinkService
{
    public function getLinkBySlug(string $slug);

    public function getFilesBySlug(string $slug);
}
