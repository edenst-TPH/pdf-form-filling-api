<?php

namespace App\Action\Job;

use App\Domain\Job\Data\JobReaderResult;
use App\Domain\Job\Service\JobReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class JobReaderAction
{
    private JobReader $jobReader;

    private JsonRenderer $renderer;

    public function __construct(JobReader $jobReader, JsonRenderer $jsonRenderer)
    {
        $this->jobReader = $jobReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $jobId = (int)$args['job_id'];

        // Invoke the domain and get the result
        $job = $this->jobReader->getJob($jobId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($job));
    }

    private function transform(JobReaderResult $job): array
    {
        return [
					'id' => $job->id,
					'id_document' => $job->id_document,
					'size' => $job->size,
					'state' => $job->state,
					'started_at' => $job->started_at,
					'finished_at' => $job->finished_at,
					'created_at' => $job->created_at,
        ];
    }
}