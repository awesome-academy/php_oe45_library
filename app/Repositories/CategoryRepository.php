<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\RepositoryInterface\CategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{

    public function getModel()
    {
        return Category::class;
    }
}
