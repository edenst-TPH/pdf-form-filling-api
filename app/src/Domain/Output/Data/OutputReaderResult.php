<?php

namespace App\Domain\Output\Data;

/**
 * DTO.
 */
final class OutputReaderResult
{
	public ?int $id = null;
	public ?string $uuid = null;
    public ?string $created_at = null;
    public ?int $id_job = null;
    public ?string $uuid_job = null;
    public ?string $state_job = null;
	public ?int $size_job = null;
}