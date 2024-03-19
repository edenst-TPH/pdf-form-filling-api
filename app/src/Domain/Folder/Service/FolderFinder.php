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
            $folder->name = $folderRow['name'];
            $folder->email = $folderRow['email'];
            $folder->organisation = $folderRow['organisation'];
            $folder->maxProjects = $folderRow['max_projects'];
            
            $result->folders[] = $folder;
        }

        return $result;
    }
}