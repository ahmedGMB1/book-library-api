<?php 

namespace App\Repositories\Interfaces;

interface BookRepositoryInterface extends BaseRepositoryInterface
{
    // additional methods specific to the book repository
    public function search(array $criteria, array $relations = [], $perPage = 12);
}