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
    private $book;
    private $author;
    private $publisher;
    private $category;

    public function __construct(Book $book, Author $author, Publisher $publisher, Category $category)
    {
        $this->book = $book;
        $this->author = $author;
        $this->publisher = $publisher;
        $this->category = $category;
    }
    public function index()
    {
        $categories = Category::whereNull('parent_id')->get();

        $books = DB::table('books')
                ->join('authors', 'authors.author_id', '=', 'books.author_id')
                ->join('publishers', 'publishers.pub_id', '=', 'books.pub_id')
                ->paginate(config('app.quantitybooks'));

        return view('user.books.index', compact(['books', 'categories']));
    }

    public function detail($id)
    {
        $categories = Category::whereNull('parent_id')->get();
        $book = $this->book->find($id);
        $authors = $this->author->all();
        $publishers = $this->publisher->all();

        return view('user.books.detail', compact(['book', 'authors', 'publishers', 'categories']));
    }

    public function indexBookCategory($cate_id)
    {
        $categories = Category::whereNull('parent_id')->get();
        $category_name = DB::table('categories')->where('categories.cate_id', $cate_id)->limit(1)->get();

        $books = DB::table('books')
            ->join('categories', 'categories.cate_id', '=', 'books.cate_id')
            ->where('categories.cate_id', $cate_id)
            ->paginate(config('app.quantitybooks'));

        return view('user.books.book_category', compact('books', 'categories', 'category_name'));
    }
}
