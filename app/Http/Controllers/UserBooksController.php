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

        $books = Book::with(['author', 'publisher', 'category'])->paginate(config('app.quantitybooks'));

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

        $category_name = Category::where('cate_id', $cate_id)->take(1)->get();

        $books = Book::with('category')
                 ->where('cate_id', $cate_id)
                 ->paginate(config('app.quantitybooks'));

        return view('user.books.book_category', compact('books', 'categories', 'category_name'));
    }
}
