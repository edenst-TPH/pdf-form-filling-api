<?php

namespace App\Domain\Auth\Service;

use App\Domain\Auth\Service\AuthValidator;

final class AuthLogin {

    private AuthValidator $authValidator;

    public function __construct(AuthValidator $authValidator) {
        $this->authValidator = $authValidator;
    }

    public function login(array $data) {
        
        // Input validation
        $this->authValidator->validateLogin($data);

        // Password check

        // Session Handling
    }
}