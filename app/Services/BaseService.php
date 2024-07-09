<?php 

namespace App\Services;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Services\Interfaces\BaseServiceInterface;

class BaseService implements BaseServiceInterface
{
    protected $repository;

    public function __construct(BaseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all(array $relations = [], $perPage = 12)
    {
        return empty($relations) ? $this->repository->all() : $this->repository->all($relations, $perPage);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function find($id, array $relations = [])
    {
        return empty($relations) ? $this->repository->find($id) : $this->repository->find($id, $relations);
    }

    public function update(array $data, $id)
    {
        return $this->repository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
