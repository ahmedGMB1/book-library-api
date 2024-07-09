<?php 

namespace App\Services\Interfaces;

interface BookServiceInterface extends BaseServiceInterface
{
    // additional methods specific to the book service
    public function search(array $criteria, array $relations = [], $perPage = 12);
}
