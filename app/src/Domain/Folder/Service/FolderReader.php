<?php

namespace App\Domain\Folder\Service;

use App\Domain\Folder\Data\FolderReaderResult;
use App\Domain\Folder\Repository\FolderRepository;
use DomainException;

/**
 * Service.
 */
final class FolderReader
{
    private FolderRepository $repository;

    /**
     * The constructor.
     *
     * @param FolderRepository $repository The repository
     */
    public function __construct(FolderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read a folder.
     *
     * @param int $folderId The folder id
     *
     * @return FolderReaderResult The result
     */
    public function getFolder(int $folderId): FolderReaderResult
    {
        // Input validation
        $this->validateFolderRead($folderId);

        // Fetch data from the database
        $folderRow = $this->repository->getFolderById($folderId);

        // Optional: Add or invoke your complex business logic here
        // ...

        // Create domain result
        $result = new FolderReaderResult();
        $result->id = $folderRow['id'];
        $result->id_user = $folderRow['id_user'];
        $result->title = $folderRow['title'];
        $result->description = $folderRow['description'];
        $result->created_at = $folderRow['created_at'];
        // $result->updated_at = $folderRow['updated_at'];

        return $result;
    }

    public function validateFolderRead(int $folderId) {
        if (!$this->repository->existsFolderId($folderId)) {
            throw new DomainException(sprintf('Folder not found: %s', $folderId));
        }
    }
}