<?php

namespace App\Repositories;

use App\Models\Borrow;
use App\Repositories\RepositoryInterface\BorrowRepositoryInterface;

class BorrowRepository extends BaseRepository implements BorrowRepositoryInterface
{

    public function getModel()
    {
        return Borrow::class;
    }

    public function getUncheckedBorrow()
    {
        return Borrow::where('borrow_status', config('app.unapproved'))->count();
    }
}
