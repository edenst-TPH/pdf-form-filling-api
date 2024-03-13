<?php

namespace App\Domain\Customer\Service;

use App\Domain\Customer\Repository\CustomerRepository;
use Psr\Log\LoggerInterface;
use DomainException;

final class CustomerDeleter
{
    private CustomerRepository $repository;
    private LoggerInterface $logger;

    public function __construct(
        CustomerRepository $repository,
        LoggerInterface $logger
    ) {
        $this->repository = $repository;
        $this->logger = $logger;
    }

    public function deleteCustomer($customerId): void
    {
        $this->validateCustomerDelete($customerId);

        $this->repository->deleteCustomerById($customerId);

        $this->logger->info(sprintf('Customer deleted successfully: %s', $customerId));

    }

    public function validateCustomerDelete(int $customerId): void 
    {
        if(!$this->repository->existsCustomerId($customerId)) {
            throw new DomainException(sprintf('Customer not found: %s', $customerId));
        }
    }
}