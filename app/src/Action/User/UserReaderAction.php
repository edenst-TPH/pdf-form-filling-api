<?php

namespace App\Action\User;

use App\Domain\User\Data\UserReaderResult;
use App\Domain\User\Service\UserReader;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UserReaderAction
{
    private UserReader $userReader;

    private JsonRenderer $renderer;

    public function __construct(UserReader $userReader, JsonRenderer $jsonRenderer)
    {
        $this->userReader = $userReader;
        $this->renderer = $jsonRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        // Fetch parameters from the request
        $userId = (int)$args['user_id'];

        // Invoke the domain and get the result
        $user = $this->userReader->getUser($userId);

        // Transform result and render to json
        return $this->renderer->json($response, $this->transform($user));
    }

    private function transform(UserReaderResult $user): array
    {
        return [
					'id' => $user->id,
					'email' => $user->email,
					'firstname' => $user->firstname,
					'lastname' => $user->lastname,
					//'password' => $user->password,
                    'role' => $user->role,
					'organisation' => $user->organisation,
					'created_at' => $user->created_at,
					'updated_at' => $user->updated_at,
        ];
    }
}