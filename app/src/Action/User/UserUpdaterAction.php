<?php

namespace App\Action\User;

use App\Domain\User\Service\UserUpdater;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UserUpdaterAction
{
    private UserUpdater $userUpdater;

    private JsonRenderer $renderer;

    public function __construct(UserUpdater $userUpdater, JsonRenderer $jsonRenderer)
    {
        $this->userUpdater = $userUpdater;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Extract the form data from the request body
        $userId = (int)$args['user_id'];
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $this->userUpdater->updateUser($userId, $data);

        // Build the HTTP response
        return $this->renderer->json($response);
    }
}