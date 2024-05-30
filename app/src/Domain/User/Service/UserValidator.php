<?php

namespace App\Domain\User\Service;

use App\Support\Validation\ValidationException;
use Cake\Validation\Validator;

final class UserValidator
{
    public function validateUser(array $data): void
    {
        $validator = new Validator();
        $validator
            ->requirePresence('email', true, 'Input required')
            ->email('email', false, 'Invalid email address')

            ->requirePresence('firstname', true, 'Input required')
            ->notEmptyString('firstname', 'Input required')
            ->maxLength('firstname', 100, 'Too long, 100 chars max')

            ->requirePresence('lastname', true, 'Input required')
            ->notEmptyString('lastname', 'Input required')
            ->maxLength('lastname', 100, 'Too long, 100 chars max')

            ->requirePresence('organisation', true, 'Input required')
            ->notEmptyString('organisation', 'Input required')
            ->maxLength('organisation', 100, 'Too long, 100 chars max')

            ->requirePresence('password', true, 'Input required')
            ->notEmptyString('password', 'Input required')
            ->maxLength('password', 100, 'Too long, 100 chars max')


            ->requirePresence('role', true, 'Input required')
            ->notEmptyString('role', 'Input required')
            ->maxLength('role', 100, 'Too long, 100 chars max')
            
            // ->naturalNumber('max_projects', 'Invalid number')
            ;

        $errors = $validator->validate($data);

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
}