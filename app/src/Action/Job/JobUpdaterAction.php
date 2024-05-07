<?php

namespace App\Action\Job;

use App\Domain\Job\Service\JobUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class JobUpdaterAction
{
    private JobUpdater $jobUpdater;

    private JsonRenderer $renderer;

    public function __construct(JobUpdater $jobUpdater, JsonRenderer $jsonRenderer)
    {
        $this->jobUpdater = $jobUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $jobId = (int)$args['job_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $this->jobUpdater->updateJob($jobId, $data);

        // Build the HTTP response
        return $this->renderer->json($response);
    }
}