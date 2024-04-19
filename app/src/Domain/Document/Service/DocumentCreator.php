<?php

namespace App\Domain\Document\Service;

use App\Domain\Document\Repository\DocumentRepository;
use App\Domain\Document\Service\DocumentValidator;
use Psr\Log\LoggerInterface;

final class DocumentCreator
{
    private DocumentRepository $repository;

    private DocumentValidator $documentValidator;

    private LoggerInterface $logger;
    
    public function __construct(
        DocumentRepository $repository,
        DocumentValidator $documentValidator,
        LoggerInterface $logger
    ) {
        $this->repository = $repository;
        $this->documentValidator = $documentValidator;
        $this->logger = $logger;
    }

    public function createDocument(array $data): int
    {
        // // Input validation
        $this->documentValidator->validateDocument($data);

        // Insert document and get new document ID
        $documentId = $this->repository->insertDocument($data);

        // // Logging
        $this->logger->info(sprintf('Document created successfully: %s', $documentId));

        return $documentId;
    }

}