<?php

namespace App\Support\Auth;

use RuntimeException;
use Throwable;

final class AuthenticationException extends RuntimeException {

    private array $errors;

    public function __construct( 
    string $message,
    array $errors = [],
    int $code = 401,
    Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

}