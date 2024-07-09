<?php 

namespace App\Services\Interfaces;

interface AuthorServiceInterface extends BaseServiceInterface
{
    // additional methods specific to the author service
    public function search(array $criteria, array $relations = [], $perPage = 10);
}
