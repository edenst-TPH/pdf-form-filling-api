<?php

namespace App\Domain\Folder\Service;

use App\Domain\Folder\Repository\FolderRepository;
use App\Domain\Folder\Service\FolderValidator;
use Psr\Log\LoggerInterface;

final class FolderCreator
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

    public function createFolder(array $data): int
    {
        // // Input validation
        $this->folderValidator->validateFolder($data);

        // Insert folder and get new folder ID
        $folderId = $this->repository->insertFolder($data);

        // // Logging
        $this->logger->info(sprintf('Folder created successfully: %s', $folderId));

        return $folderId;
    }

}