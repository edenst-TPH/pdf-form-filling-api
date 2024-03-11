<?php

namespace App\Factory;

use Cake\Database\Connection;
use Cake\Database\Query;
use UnexpectedValueException;

final class QueryFactory
{
    private Connection $connection;
    
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function newQuery(): Query
    {
        return $this->connection->newQuery();
    }

    public function newSelect(string $table): Query
    {
        return $this->newQuery()->from($table);
    }

    public function newUpdate(string $table): Query
    {
        return $this->newQuery()->update($table);
    }

    public function newInsert(string $table, array $data): Query
    {
        return $this->newQuery()
        ->insert(array_keys($data))
        ->into($table)
        ->values($data);
    }

    public function newDelete(string $table): Query
    {
        return $this->newQuery()->delete($table);
    }
}