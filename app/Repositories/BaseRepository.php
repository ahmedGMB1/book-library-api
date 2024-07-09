<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Interfaces\BaseRepositoryInterface;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $relations = [], $perPage = null)
    {
        $perPage = $perPage ?? config('pagination.per_page');
        return $this->model->with($relations)->paginate($perPage);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function find($id, array $relations = [])
    {
        return $this->model->with($relations)->find($id);
    }

    public function update(array $data, $id)
    {
        $record = $this->model->find($id);
        if ($record) {
            $record->update($data);
            return $record;
        }
        return null;
    }

    public function delete($id)
    {
        $record = $this->model->find($id);
        if ($record) {
            $record->delete();
            return true;
        }
        return false;
    }
}
