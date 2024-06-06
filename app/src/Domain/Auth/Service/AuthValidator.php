<?php

namespace App\Domain\Auth\Service;

use App\Support\Auth\AuthenticationException;
use Cake\Validation\Validator;

final class AuthValidator
{
    public function validateLogin(array $data): void
    {
        $validator = new Validator();
        $validator
            ->requirePresence('email', true, 'Input required')
            ->notEmptyString('email', 'Input required')
            //->nonNegativeInteger('id_folder', 'Folder id must be a positive integer')

            ->requirePresence('password', true, 'Input required')
            ->notEmptyString('password', 'Input required')
            ->maxLength('password', 255, 'Too long, 255 characters max')
            ->minLength('password', 3, 'Too short, 3 characters min');

            //  add CSRF protection (anti API access)

        $errors = $validator->validate($data);

        if($errors) {
            throw new AuthenticationException("Please check your input", $errors);            
        }

        //  instead of throwing an error we will redirect to /login and return flash messages
        // if ($errors) {
        //     throw new ValidationException('Please check your input', $errors);
        // }
    }
}