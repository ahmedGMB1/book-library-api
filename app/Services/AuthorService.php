<?php 

namespace App\Services;

use App\Repositories\Interfaces\AuthorRepositoryInterface;
use App\Services\Interfaces\AuthorServiceInterface;

class AuthorService extends BaseService implements AuthorServiceInterface
{
    protected $authorRepository;
    public function __construct(AuthorRepositoryInterface $authorRepository)
    {
        parent::__construct($authorRepository);
        $this->authorRepository = $authorRepository;
    }

    public function search(array $criteria, array $relations = [], $perPage = 10)
    {
        return $this->authorRepository->search($criteria, $relations, $perPage);
    }

}
