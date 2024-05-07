<?php

namespace App\Action\Job;

use App\Domain\Job\Service\JobCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class JobCreatorAction
{
    private JsonRenderer $renderer;

    private JobCreator $jobCreator;

    public function __construct(JobCreator $jobCreator, JsonRenderer $renderer)
    {
        $this->jobCreator = $jobCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $jobId = $this->jobCreator->createJob($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['job_id' => $jobId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}