<?php 

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\Interfaces\BookRepositoryInterface;

class BookRepository extends BaseRepository implements BookRepositoryInterface
{
    public function __construct(Book $model)
    {
        parent::__construct($model);
    }
   
    public function search(array $criteria, array $relations = [], $perPage = 12)
    {
        $query = $this->model->with($relations);

        if (isset($criteria['title'])) {
            $query->where('title', 'like', '%' . $criteria['title'] . '%');
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

