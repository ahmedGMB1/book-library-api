<?php

namespace App\Repositories\Interfaces;

interface AuthorRepositoryInterface extends BaseRepositoryInterface
{
    // additional methods specific to the author repository
    public function search(array $criteria, array $relations = [], $perPage = 10);
}