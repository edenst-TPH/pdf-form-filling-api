<?php

namespace App\Domain\Folder\Service;

use App\Domain\Folder\Repository\FolderRepository;
use DomainException;
use Psr\Log\LoggerInterface;

final class FolderUpdater
{
    private FolderRepository $repository;

    private FolderValidator $folderValidator;

    private LoggerInterface $logger;

    public function __construct(
        FolderRepository $repository,
        FolderValidator $folderValidator,
        LoggerInterface $logger
    ) {
        $this->repository = $repository;
        $this->folderValidator = $folderValidator;
        $this->logger = $logger;
    }

    public function updateFolder(int $folderId, array $data): void
    {
        // Input validation
        $this->validateFolderUpdate($folderId, $data);

        // Update the row
        $this->repository->updateFolder($folderId, $data);

        // Logging
        $this->logger->info(sprintf('Folder updated successfully: %s', $folderId));
    }

    public function validateFolderUpdate(int $folderId, array $data): void
    {
        if (!$this->repository->existsFolderId($folderId)) {
            throw new DomainException(sprintf('Folder not found: %s', $folderId));
        }

        $this->folderValidator->validateFolder($data);
    }
}