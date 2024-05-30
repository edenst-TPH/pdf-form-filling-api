<?php

namespace App\Action\User;

use App\Domain\User\Service\UserCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UserCreatorAction
{
    private JsonRenderer $renderer;

    private UserCreator $userCreator;

    public function __construct(UserCreator $userCreator, JsonRenderer $renderer)
    {
        $this->userCreator = $userCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $userId = $this->userCreator->createUser($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['user_id' => $userId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}