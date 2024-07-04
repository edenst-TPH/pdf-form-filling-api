<?php

namespace App\Action\Test;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use mikehaertl\pdftk\Pdf;
use App\Filesystem\Storage;

final class TestPhpPdftkAction {

    private Storage $storage;

    public function __construct(Storage $storage) 
    {
        $this->storage = $storage;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Get Data Fields from file in storage
        $path = $this->storage->read("/foo/b7a1fafe9765518d.pdf");
        $pdf = new Pdf($path);

        $result = $pdf->getDataFields();

        $response->getBody()->write(json_encode($result));

        return $response->withHeader('Content-Type', 'application/json');
    }


}