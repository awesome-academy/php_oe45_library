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

    public function getCateParent()
    {
        return Category::whereNull('parent_id')->get();
    }

    public function getOneCateName($cate_id)
    {
        return Category::where('cate_id', $cate_id)->take(1)->get();
    }
}
