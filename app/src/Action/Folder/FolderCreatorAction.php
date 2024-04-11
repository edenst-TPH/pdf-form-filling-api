<?php

namespace App\Action\Folder;

use App\Domain\Folder\Service\FolderCreator;
use App\Renderer\JsonRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class FolderCreatorAction
{
    private JsonRenderer $renderer;

    private FolderCreator $folderCreator;

    public function __construct(FolderCreator $folderCreator, JsonRenderer $renderer)
    {
        $this->folderCreator = $folderCreator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // Extract the form data from the request body
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result
        $folderId = $this->folderCreator->createFolder($data);

        // Build the HTTP response
        return $this->renderer
            ->json($response, ['folder_id' => $folderId])
            ->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}