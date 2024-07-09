<?php 

namespace App\Services;

use App\Repositories\Interfaces\BookRepositoryInterface;
use App\Services\Interfaces\BookServiceInterface;

class BookService extends BaseService implements BookServiceInterface
{
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        parent::__construct($bookRepository);
        $this->bookRepository = $bookRepository;
    }

    public function search(array $criteria, array $relations = [], $perPage = 12)
    {
        return $this->bookRepository->search($criteria, $relations, $perPage);
    }
}
