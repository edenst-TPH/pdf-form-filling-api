<?php

namespace App\Domain\Folder\Data;

/**
 * DTO.
 */
final class FolderFinderItem
{
    public ?int $id = null;
    public ?int $id_customer = null;
    public ?string $title = null;
    public ?string $description = null;
    public ?int $created = null;
}