<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use App\Http\Requests\BookRequest;
use App\Components\Recusive;
use DB;
use App\Repositories\RepositoryInterface\BookRepositoryInterface;
use App\Repositories\RepositoryInterface\AuthorRepositoryInterface;
use App\Repositories\RepositoryInterface\PublisherRepositoryInterface;
use App\Repositories\RepositoryInterface\CategoryRepositoryInterface;

class BookController extends Controller
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
        
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = $this->bookRepository->getAllBooks();

        return view('admin.books.index', compact('books'));
    }

    public function getCategory($parentID)
    {
        $data = $this->categoryRepository->getAll();
        $recusive = new Recusive($data);
        $categoryOption = $recusive->categoryRecusive($parentID);

        return $categoryOption;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryOption = $this->getCategory('');
        $authors = $this->authorRepository->getAll();
        $publishers = $this->publisherRepository->getAll();

        return view('admin.books.add', compact(['categoryOption', 'authors', 'publishers']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        $books = $request->all();

        if ($file = $request->file('book_img')) {
            $name_image = $file->getClientOriginalName();
            $file->move('images', $name_image);
            $books['book_img'] = $name_image;
        }

        $this->bookRepository->create($books);

        return redirect()->route('books.index')->with('add_success', trans('message.add_success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($book_id)
    {
        $book = $this->bookRepository->find($book_id);
        $categoryOption = $this->getCategory($book->cate_id);
        $authors = $this->authorRepository->getAll();
        $publishers = $this->publisherRepository->getAll();

        return view('admin.books.edit', compact(['book', 'categoryOption', 'authors', 'publishers']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, $book_id)
    {
        $bookUpdate = $request->all();

        if ($file = $request->file('book_img')) {
            $name_image = $file->getClientOriginalName();
            $file->move('images', $name_image);
            $bookUpdate['book_img'] = $name_image;
        }

        $this->bookRepository->update($book_id, $bookUpdate);

        return redirect()->route('books.index')->with('update_success', trans('message.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($book_id)
    {
        $this->bookRepository->delete($book_id);

        return redirect()->route('books.index')->with('del_success', trans('message.del_success'));
    }
}
