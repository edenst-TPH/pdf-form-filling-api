<?php

namespace App\Action\Dashboard;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

final class DashboardHomeAction
{
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {

        $viewData = [
            'version' => "0.1"
        ];
        
        return $this->twig->render($response, 'dashboard.home.twig', $viewData);
    }
}
