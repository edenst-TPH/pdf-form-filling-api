<?php

namespace App\Action\Job;

use App\Domain\Job\Data\JobFinderResult;
use App\Domain\Job\Service\JobFinder;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class JobFinderAction
{
    private JobFinder $jobFinder;

    private JsonRenderer $renderer;

    public function __construct(JobFinder $jobFinder, JsonRenderer $jsonRenderer)
    {
        $this->jobFinder = $jobFinder;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Optional: Pass parameters from the request to the service method
        // ...

        $jobs = $this->jobFinder->findJobs();

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($jobs));
    }

    public function transform(JobFinderResult $result): array
    {
        $jobs = [];

        foreach ($result->jobs as $job) {
            $jobs[] = [
                'id' => $job->id,
                'id_document' => $job->id_document,
                'size' => $job->size,
                'state' => $job->state,
                'started_at' => $job->started_at,
                'finished_at' => $job->finished_at,
                'created_at' => $job->created_at,
            ];
        }

        return [
            'jobs' => $jobs,
        ];
    }
}