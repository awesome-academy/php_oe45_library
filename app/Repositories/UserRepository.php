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
}
