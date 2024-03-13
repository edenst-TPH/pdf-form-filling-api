<?php

namespace App\Domain\Customer\Service;

use App\Domain\Customer\Repository\CustomerRepository;

final class CustomerCreator
{
    private CustomerRepository $repository;

    
    public function __construct(
        CustomerRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function createCustomer(array $data): int
    {
        // // Input validation
        // $this->customerValidator->validateCustomer($data);

        // Insert customer and get new customer ID
        $customerId = $this->repository->insertCustomer($data);

        // // Logging
        // $this->logger->info(sprintf('Customer created successfully: %s', $customerId));

        return $customerId;
    }

}