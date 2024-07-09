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

        if (isset($criteria['email'])) {
            $query->where('email', 'like', '%' . $criteria['email'] . '%');
        }

        if (isset($criteria['phone'])) {
            $query->where('phone', 'like', '%' . $criteria['phone'] . '%');
        }

        if (isset($criteria['author_name'])) {
            $query->whereHas('author', function ($q) use ($criteria) {
                $q->where('first_name', 'like', '%' . $criteria['author_name'] . '%')
                  ->orWhere('last_name', 'like', '%' . $criteria['author_name'] . '%');
            });
        }

        return $query->paginate($perPage);
    }

}
