<?php

namespace App\Action\Job;

use App\Domain\Job\Service\JobDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class JobDeleterAction
{
    private JobDeleter $jobDeleter;

    private JsonRenderer $renderer;

    public function __construct(JobDeleter $jobDeleter, JsonRenderer $renderer)
    {
        $this->jobDeleter = $jobDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $jobId = (int)$args['job_id'];

        // Invoke the domain (service class)
        $this->jobDeleter->deleteJob($jobId);

        // Render the json response
        return $this->renderer->json($response);
    }
}