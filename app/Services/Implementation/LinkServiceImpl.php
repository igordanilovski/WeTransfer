<?php

namespace App\Services\Implementation;

use App\Models\FileName;
use App\Models\FileUploadDTO;
use App\Repositories\FileModelRepository;
use App\Repositories\LinkModelRepository;
use App\Services\LinkService;

class LinkServiceImpl implements LinkService
{
    private readonly FileModelRepository $fileModelRepository;
    private readonly LinkModelRepository $linkModelRepository;

    public function __construct(FileModelRepository $fileModelRepository, LinkModelRepository $linkModelRepository)
    {
        $this->fileModelRepository = $fileModelRepository;
        $this->linkModelRepository = $linkModelRepository;
    }

    public function getLinkBySlug(string $slug)
    {
        return $this->linkModelRepository->findBySlug($slug);
    }

    /**
     * @param string $slug
     * @return FileUploadDTO
     */
    public function getFilesBySlug(string $slug): FileUploadDTO
    {
        $linkModel = $this->getLinkBySlug($slug);

        $files = $this->fileModelRepository->getFilesByLinkId($linkModel->id);

        $fileNameVar = [];

        foreach ($files as $file){
            $tempFileName = new FileName();
            $tempFileName->populateProperties($file);

            $fileNameVar[] = $tempFileName->getAllNamesAsArray();
        }

        $result = new FileUploadDTO($linkModel->slug, $fileNameVar);
        return $result;
    }
}
