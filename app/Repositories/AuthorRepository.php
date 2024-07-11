<?php

namespace App\Repositories;

use App\Models\Author;
use App\Repositories\Interfaces\AuthorRepositoryInterface;

class AuthorRepository extends BaseRepository implements AuthorRepositoryInterface
{
    public function __construct(Author $model)
    {
        parent::__construct($model);
    }

    public function search(array $criteria, array $relations = [], $perPage = 10)
    {
        
        $query = $this->model->with($relations);

        $searchableFields = ['email', 'phone', 'first_name', 'last_name'];

        $query->where(function ($query) use ($criteria, $searchableFields) {
            foreach ($searchableFields as $field) {
                if (isset($criteria[$field])) {
                    $query->orWhere($field, 'like', '%' . $criteria[$field] . '%');
                }
            }
        });

        return $query->paginate($perPage);

    }

}
