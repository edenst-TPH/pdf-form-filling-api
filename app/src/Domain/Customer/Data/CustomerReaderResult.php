<?php

namespace App\Domain\Customer\Data;

/**
 * DTO.
 */
final class CustomerReaderResult
{
    public ?int $id = null;
    public ?string $email = null;
    public ?string $firstname = null;
    public ?string $lastname = null;
    public ?string $password = null;
    public ?string $organisation = null;
    public ?string $created_at = null;
    public ?string $updated_at = null;
}