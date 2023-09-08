<?php

namespace App\Services\Implementation;

use App\Models\FileName;
use App\Models\FileUploadDTO;
use App\Repositories\FileModelRepository;
use App\Repositories\LinkModelRepository;
use App\Services\LinkService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

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



    /**
     * @param string $slug
     * @return false|string
     */
    public function downloadFilesBySlug(string $slug): bool|string
    {

        $linkModel = $this->getLinkBySlug($slug);
        $files = $this->fileModelRepository->getFilesByLinkId($linkModel->id);

        $zipFilePath = tempnam(sys_get_temp_dir(), 'zip');
        $zip = new ZipArchive();
        $zipContents = '';

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {

            foreach ($files as $file){
                $objectContents = Storage::disk('s3')->get($file->folder . '/' . $file->hashed_name);
                $zip->addFromString($file->original_name, $objectContents);
            }

            $zip->close();
            $zipContents = file_get_contents($zipFilePath);
        }

        return $zipContents;
    }

    public function getLinksByLoggedUser()
    {
        return $this->linkModelRepository->findByUser(Auth::id());
    }

    /**
     * @param $slug
     * @return void
     */
    public function openLink($slug): void
    {
        $link = self::getLinkBySlug($slug);

        $this->linkModelRepository->incrementTimeOpened($link);
    }
}
