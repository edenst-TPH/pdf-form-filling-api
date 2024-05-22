<?php

namespace App\Action\Test;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TestMiscAction {

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        
        $test = array();

        $test["password"] = $_ENV['DB_PASSWORD'] ?: 'password';

        $test["date"] = date("Y-m-d h:i:s",time());

        $response->getBody()->write(json_encode($test));

        return $response->withHeader('Content-Type', 'application/json');
    }
}