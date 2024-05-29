<?php

namespace App\Action\Output;

use App\Domain\Output\Service\OutputReader;
use App\Domain\Output\Service\OutputStreamer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


final class OutputStreamerAction
{
    private OutputReader $outputReader;
    private OutputStreamer $outputStreamer;


    public function __construct(OutputReader $outputReader, OutputStreamer $outputStreamer) {
        $this->outputReader = $outputReader;
        $this->outputStreamer = $outputStreamer;
    }

    public function __invoke(
        Request $request,
        Response $response,
        array $args
    ): Response {

        // Fetch parameters from the request
        $uuid = (string) $args['output_uuid'];
        
        $output = $this->outputReader->getOutput($uuid);
        $stream = $this->outputStreamer->getStream($output);

        $response = $response
        ->withHeader('Content-Type', 'application/zip')
        ->withHeader('Content-Disposition', 'attachment; filename="'.$uuid.'.pdf"');

        return $response->withBody($stream);
    }
}