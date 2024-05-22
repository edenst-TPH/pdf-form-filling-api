<?php

namespace App\Action\Test;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use mikehaertl\pdftk\Pdf;

final class TestPhpPdftkAction {

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $pdf = new Pdf('pdftk_test_document.pdf');
        $result = $pdf->getDataFields();

        $response->getBody()->write(json_encode($result));

        return $response->withHeader('Content-Type', 'application/json');
    }


}