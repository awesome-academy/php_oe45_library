<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateBorrowRequest;
use DB;

class UserRequestController extends Controller
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

    public function create($id)
    {
        $categories = Category::whereNull('parent_id')->get();
        $authors = $this->author->all();
        $publishers = $this->publisher->all();
        $book = $this->book->find($id);
        if (!$book) {
            return abort(404);
        } else {
            return view('user.requests.create', compact(['book', 'authors', 'publishers', 'categories']));
        }
    }

    public function store(CreateBorrowRequest $request)
    {
        $request->all();
        $same_request = (new Borrow)->where([['book_id', $request->book], ['user_id', Auth::id()]])->first();

        if ($same_request) {
            return redirect()->route('request.index')->with('error', trans('requests.error'));
        } else {
            $request = Borrow::create([
                'book_id' => $request->book_id,
                'user_id' => Auth::id(),
                'borrow_date' => $request->borrow_date,
                'return_date' => $request->return_date,
                'book_status' => 0,
            ]);
            if ($request) {
                return redirect()->route('request.index')->with('create_success', trans('user.request.create_success'));
            } else {
                return redirect()->route('request.index')->with('error', trans('request.fail'));
            }
        }
    }

    public function index()
    {
        $categories = Category::whereNull('parent_id')->get();
        $borrows = DB::table('borrows')
                    ->join('books', 'books.book_id', '=', 'borrows.book_id')
                    ->paginate(config('app.paginate'));

        return view('user.requests.index', compact(['categories', 'borrows']));
    }
}
