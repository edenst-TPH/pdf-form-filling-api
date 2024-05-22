<?php

namespace App\Action\Test;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TestPhpAction {

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
    
        ob_start () ;
        phpinfo () ;
        $pinfo = ob_get_clean () ;
    
        $response->getBody()->write($pinfo);
        return $response;
    }

}