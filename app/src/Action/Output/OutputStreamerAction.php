<?php

namespace App\Action\Output;

use App\Domain\Output\Service\OutputReader;
use App\Domain\Output\Service\OutputStreamer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Filesystem\Storage;
use Nyholm\Psr7\Stream;


final class OutputStreamerAction
{
    private OutputReader $outputReader;
    private OutputStreamer $outputStreamer;
    private Storage $storage;


    public function __construct(OutputReader $outputReader, OutputStreamer $outputStreamer, Storage $storage) {
        $this->outputReader = $outputReader;
        $this->outputStreamer = $outputStreamer;
        $this->storage = $storage;
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