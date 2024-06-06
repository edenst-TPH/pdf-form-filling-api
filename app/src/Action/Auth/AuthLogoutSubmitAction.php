<?php

namespace App\Action\Auth;

use Odan\Session\SessionManagerInterface;
use Slim\Routing\RouteContext;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


final class AuthLogoutSubmitAction
{
    private SessionManagerInterface $sessionManager;

    public function __construct(SessionManagerInterface $sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Logout user
        $this->sessionManager->destroy();
        
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('home');

        return $response->withStatus(302)->withHeader('Location', $url);
    }
}