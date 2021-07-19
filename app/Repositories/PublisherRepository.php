<?php

namespace App\Repositories;

use App\Models\Publisher;
use App\Repositories\RepositoryInterface\PublisherRepositoryInterface;

class PublisherRepository extends BaseRepository implements PublisherRepositoryInterface
{

    public function getModel()
    {
        return Publisher::class;
    }
}
