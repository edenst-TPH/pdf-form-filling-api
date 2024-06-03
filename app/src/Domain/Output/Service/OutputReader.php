<?php

namespace App\Domain\Output\Service;

use App\Filesystem\Storage;
use App\Domain\Output\Repository\OutputRepository;
use App\Domain\Output\Data\OutputReaderResult;
use Symfony\Component\Uid\Uuid;

use DomainException;
use Psr\Log\LoggerInterface;

final class OutputReader
{
    private OutputRepository $repository;


    public function __construct(
        Storage $storage, 
        OutputRepository $repository
        ) {
        $this->repository = $repository;
    }

    public function getOutput(string $outputUuid)
    {
        $this->validateOutputRead($outputUuid);

        $outputRow = $this->repository->getFinishedJobOutputByUuid($outputUuid);

        //  Business Logic
        //  tbd

        // Create domain result
        $result = new OutputReaderResult();
        $result->id = $outputRow['id'];
        $result->uuid = $outputRow['uuid'];
        $result->created_at = $outputRow['created_at'];
        $result->id_job = $outputRow['job_id'];
        $result->uuid_job = $outputRow['job_uuid'];
        $result->state_job = $outputRow['job_state'];
        $result->size_job = $outputRow['job_size'];

        return $result;
    }

    public function validateOutputRead($uuid) {

        if(!Uuid::isValid($uuid)) {
            throw new DomainException("Invalid output id.");
        }

    }
}