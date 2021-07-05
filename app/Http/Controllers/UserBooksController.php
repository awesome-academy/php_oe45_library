<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use DB;

class UserBooksController extends Controller
{
    protected $book;
    private $author;
    private $publisher;

    public function __construct(Book $book, Author $author, Publisher $publisher)
    {
        $this->book = $book;
        $this->author = $author;
        $this->publisher = $publisher;
    }
    public function index()
    {
        $books = DB::table('books')
                ->join('authors', 'authors.author_id', '=', 'books.author_id')
                ->join('publishers', 'publishers.pub_id', '=', 'books.pub_id')
                ->paginate(config('app.quantitybooks'));

        return view('user.books.index', compact('books'));
    }

    public function detail($id)
    {
        $book = $this->book->find($id);
        $authors = $this->author->all();
        $publishers = $this->publisher->all();

        return view('user.books.detail', compact(['book', 'authors', 'publishers']));
    }
}
