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

    public function getBookByCate($cate_id)
    {
        return Book::with('category')
                 ->where('cate_id', $cate_id)
                 ->paginate(config('app.quantitybooks'));
    }

    public function getBookRequestBorrow($id)
    {
        return Book::where('book_id', $id)->first();
    }
}
