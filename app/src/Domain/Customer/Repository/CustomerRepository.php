<?php

namespace App\Domain\Customer\Repository;

use App\Factory\QueryFactory;
use DomainException;

final class CustomerRepository 
{
    private QueryFactory $queryFactory;

    public function __construct(QueryFactory $queryFactory) 
    {
        $this->queryFactory = $queryFactory;
    }

    public function insertCustomer(array $customer): int
    {
        return (int)$this->queryFactory->newInsert('customers', $this->toRow($customer))
            ->execute()
            ->lastInsertId();        
    }

    public function getCustomerById(int $customerId): array
    {
        $query = $this->queryFactory->newSelect('customers');
        $query->select(
            [
                'id',
                'name',
                'email',
                'organisation',
                'max_projects'
            ]
        );

        $query->where(['id' => $customerId]);

        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            throw new DomainException(sprintf('Customer not found: %s', $customerId));
        }

        return $row;
    }

    public function updateCustomer(int $customerId, array $customer): void
    {
        $row = $this->toRow($customer);

        $this->queryFactory->newUpdate('customers', $row)
            ->where(['id' => $customerId])
            ->execute();
    }

    public function existsCustomerId(int $customerId): bool
    {
        $query = $this->queryFactory->newSelect('customers');
        $query->select('id')->where(['id' => $customerId]);

        return (bool)$query->execute()->fetch('assoc');
    }

    public function deleteCustomerById(int $customerId): void
    {
        $this->queryFactory->newDelete('customers')
            ->where(['id' => $customerId])
            ->execute();
    }


    private function toRow(array $customer): array
    {
        return [
            'name' => $customer['name'],
            'email' => $customer['email'],
            'organisation' => $customer['organisation'],
            'max_projects' => $customer['max_projects']
        ];
    }    
}