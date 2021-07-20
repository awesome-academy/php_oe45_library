<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\RepositoryInterface\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    public function getModel()
    {
        return User::class;
    }

    public function getAdmin()
    {
        return User::where('role_id', config('app.role'))->get();
    }
}
