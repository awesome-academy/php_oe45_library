<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use DB;
use App\Repositories\RepositoryInterface\BookRepositoryInterface;
use App\Repositories\RepositoryInterface\AuthorRepositoryInterface;
use App\Repositories\RepositoryInterface\PublisherRepositoryInterface;
use App\Repositories\RepositoryInterface\CategoryRepositoryInterface;

class UserBooksController extends Controller
{
    private $bookRepository;
    private $categoryRepository;
    private $authorRepository;
    private $publisherRepository;
    
    public function __construct(
        BookRepositoryInterface $bookRepository,
        CategoryRepositoryInterface $categoryRepository,
        AuthorRepositoryInterface $authorRepository,
        PublisherRepositoryInterface $publisherRepository
    ) {
        $this->bookRepository = $bookRepository;
        $this->categoryRepository = $categoryRepository;
        $this->authorRepository = $authorRepository;
        $this->publisherRepository = $publisherRepository;
    }

    public function index()
    {
        $categories = $this->categoryRepository->getCateParent();
        $books = $this->bookRepository->getAllBooks();

        return view('user.books.index', compact(['books', 'categories']));
    }

    public function detail($id)
    {
        $categories = $this->categoryRepository->getCateParent();
        $book = $this->bookRepository->find($id);
        $authors = $this->authorRepository->getAll();
        $publishers = $this->publisherRepository->getAll();

        return view('user.books.detail', compact(['book', 'authors', 'publishers', 'categories']));
    }

    public function indexBookCategory($cate_id)
    {
        $categories = $this->categoryRepository->getCateParent();
        $category_name = $this->categoryRepository->getOneCateName($cate_id);
        $books = $this->bookRepository->getBookByCate($cate_id);

        return view('user.books.book_category', compact('books', 'categories', 'category_name'));
    }
}
