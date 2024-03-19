<?php

namespace App\Domain\Folder\Service;

use App\Domain\Folder\Repository\FolderRepository;
use Psr\Log\LoggerInterface;
use DomainException;

final class FolderDeleter
{
    private FolderRepository $repository;
    private LoggerInterface $logger;

    public function __construct(
        FolderRepository $repository,
        LoggerInterface $logger
    ) {
        $this->repository = $repository;
        $this->logger = $logger;
    }

    public function deleteFolder($folderId): void
    {
        $this->validateFolderDelete($folderId);

        $this->repository->deleteFolderById($folderId);

        $this->logger->info(sprintf('Folder deleted successfully: %s', $folderId));

    }

    public function validateFolderDelete(int $folderId): void 
    {
        if(!$this->repository->existsFolderId($folderId)) {
            throw new DomainException(sprintf('Folder not found: %s', $folderId));
        }
    }
}