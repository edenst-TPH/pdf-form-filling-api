<?php

namespace App\Domain\Folder\Data;

/**
 * DTO.
 */
final class FolderReaderResult
{
    public ?int $id = null;
    public ?int $id_customer = null;
    public ?string $title = null;
    public ?string $description = null;
    public ?string $created = null;
}