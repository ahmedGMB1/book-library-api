<?php 

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function all(array $relations = [], $perPage = null);
    public function create(array $data);
    public function find($id, array $relations = []);
    public function update(array $data, $id);
    public function delete($id);
    
}

