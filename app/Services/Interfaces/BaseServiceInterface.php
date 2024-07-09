<?php 

namespace App\Services\Interfaces;

interface BaseServiceInterface
{
    public function all(array $relations = [], $perPage = null);
    public function create(array $data);
    public function find($id, array $relations = []);
    public function update(array $data, $id);
    public function delete($id);
}
