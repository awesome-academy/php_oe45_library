<?php

namespace App\Repositories;

use App\Models\Author;
use App\Repositories\RepositoryInterface\AuthorRepositoryInterface;

class AuthorRepository extends BaseRepository implements AuthorRepositoryInterface
{

    public function getModel()
    {
        return Author::class;
    }
}
