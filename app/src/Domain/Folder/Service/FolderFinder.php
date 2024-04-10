<?php

namespace App\Domain\Folder\Service;

use App\Domain\Folder\Data\FolderFinderItem;
use App\Domain\Folder\Data\FolderFinderResult;
use App\Domain\Folder\Repository\FolderFinderRepository;

final class FolderFinder
{
    private FolderFinderRepository $repository;

    public function __construct(FolderFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findFolders(): FolderFinderResult
    {
        // Input validation
        // ...

        $folders = $this->repository->findFolders();

        return $this->createResult($folders);
    }

    private function createResult(array $folderRows): FolderFinderResult
    {
        $result = new FolderFinderResult();

        foreach ($folderRows as $folderRow) {
            $folder = new FolderFinderItem();
            $folder->id = $folderRow['id'];
            $folder->id_customer = $folderRow['id_customer'];
            $folder->title = $folderRow['title'];
            $folder->description = $folderRow['description'];
            $folder->created_at = $folderRow['created_at'];
            // $folder->updated_at = $folderRow['updated_at'];
            
            $result->folders[] = $folder;
        }

        return $result;
    }
}