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
        // ** File ** upload
        

        // ** DB-data **
        // Data input validation
        $this->documentValidator->validateDocument($data);

        // DB-insert document data and get new document ID (int)
        $documentId = $this->repository->insertDocument($data);

        // Logging
        $this->logger->info(sprintf('Document created successfully: %s', $documentId));

        return $documentId;
    }

}