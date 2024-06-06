<?php
namespace App\Middleware;

use Odan\Session\SessionInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteContext;
use Slim\Exception\HttpNotFoundException;

final class AuthMiddleware implements MiddlewareInterface
{

    private ResponseFactoryInterface $responseFactory;
    private SessionInterface $session;
    private ServerRequestInterface $request;
    private RequestHandlerInterface $handler;

    public function __construct(
        ResponseFactoryInterface $responseFactory,
        SessionInterface $session
    ) {
        $this->responseFactory = $responseFactory;
        $this->session = $session;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface{

        $this->request = $request;
        $this->handler = $handler;

        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();

        // return NotFound for non-existent route
        if (empty($route)) {
            throw new HttpNotFoundException($request);
        }

        //  route negotiation
        $name = $route->getName();

        if($name == "register") {
            if($this->session->get('user')) {
                $routeParser = RouteContext::fromRequest($request)->getRouteParser();
                $url = $routeParser->urlFor('login');
                return $this->responseFactory->createResponse()
                ->withStatus(302)
                ->withHeader('Location', $url);
            } else {
                return $handler->handle($request);
            }
            
        }
    }

    private function determineRoute(): void
    {

    }



}



