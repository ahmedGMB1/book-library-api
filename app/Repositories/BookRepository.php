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

        $searchableFields = ['title', 'publisher', 'isbn', 'year'];

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

