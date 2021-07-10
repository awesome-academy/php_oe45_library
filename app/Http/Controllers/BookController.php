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

class BookController extends Controller
{
    private $book;
    private $category;
    private $author;
    private $publisher;
    
    public function __construct(Book $book, Category $category, Author $author, Publisher $publisher)
    {
        $this->book = $book;
        $this->category = $category;
        $this->author = $author;
        $this->publisher = $publisher;
    }
        
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::with(['author', 'publisher', 'category'])->paginate(config('app.paginate'));

        return view('admin.books.index', compact('books'));
    }

    public function getCategory($parentID)
    {
        $data = $this->category->all();
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
        $authors = $this->author->all();
        $publishers = $this->publisher->all();

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

        Book::create($books);

        return redirect()->route('books.index')->with('add_success', trans('message.add_success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $categoryOption = $this->getCategory($book->cate_id);
        $authors = $this->author->all();
        $publishers = $this->publisher->all();

        return view('admin.books.edit', compact(['book', 'categoryOption', 'authors', 'publishers']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, Book $book)
    {
        $bookUpdate = $request->all();

        if ($file = $request->file('book_img')) {
            $name_image = $file->getClientOriginalName();
            $file->move('images', $name_image);
            $bookUpdate['book_img'] = $name_image;
        }

        $book->update($bookUpdate);

        return redirect()->route('books.index')->with('update_success', trans('message.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')->with('del_success', trans('message.del_success'));
    }
}
