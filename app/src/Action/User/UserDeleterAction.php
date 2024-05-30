<?php

namespace App\Action\User;

use App\Domain\User\Service\UserDeleter;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UserDeleterAction
{
    private UserDeleter $userDeleter;

    private JsonRenderer $renderer;

    public function __construct(UserDeleter $userDeleter, JsonRenderer $renderer)
    {
        $this->userDeleter = $userDeleter;
        $this->renderer = $renderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $userId = (int)$args['user_id'];

        // Invoke the domain (service class)
        $this->userDeleter->deleteUser($userId);

        // Render the json response
        return $this->renderer->json($response);
    }
}