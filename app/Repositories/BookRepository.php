<?php

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\RepositoryInterface\BookRepositoryInterface;

class BookRepository extends BaseRepository implements BookRepositoryInterface
{

    public function getModel()
    {
        return Book::class;
    }

    public function getAllBooks()
    {
        return Book::with(['author', 'publisher', 'category'])->latest()->paginate(config('app.paginate'));
    }
}
