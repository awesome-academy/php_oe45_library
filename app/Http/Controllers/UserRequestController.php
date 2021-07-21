<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateBorrowRequest;
use App\Notifications\BorrowNotification;
use DB;
use Pusher\Pusher;
use App\Repositories\RepositoryInterface\BookRepositoryInterface;
use App\Repositories\RepositoryInterface\AuthorRepositoryInterface;
use App\Repositories\RepositoryInterface\PublisherRepositoryInterface;
use App\Repositories\RepositoryInterface\CategoryRepositoryInterface;
use App\Repositories\RepositoryInterface\BorrowRepositoryInterface;

class UserRequestController extends Controller
{
    private $bookRepository;
    private $categoryRepository;
    private $authorRepository;
    private $publisherRepository;
    private $borrowRepository;
    
    public function __construct(
        BookRepositoryInterface $bookRepository,
        CategoryRepositoryInterface $categoryRepository,
        AuthorRepositoryInterface $authorRepository,
        PublisherRepositoryInterface $publisherRepository,
        BorrowRepositoryInterface $borrowRepository
    ) {
        $this->bookRepository = $bookRepository;
        $this->categoryRepository = $categoryRepository;
        $this->authorRepository = $authorRepository;
        $this->publisherRepository = $publisherRepository;
        $this->borrowRepository = $borrowRepository;
    }

    public function create($id)
    {
        $categories = $this->categoryRepository->getCateParent();
        $authors = $this->authorRepository->getAll();
        $publishers = $this->publisherRepository->getAll();
        $book = $this->bookRepository->find($id);
        if (!$book) {
            return abort(404);
        } else {
            return view('user.requests.create', compact(['book', 'authors', 'publishers', 'categories']));
        }
    }

    public function store(CreateBorrowRequest $request)
    {
        $request->all();
        $same_request = $this->borrowRepository->getSameBorrow($request->book_id);
        $book = $this->bookRepository->getBookRequestBorrow($request->book_id);
        if ($same_request) {
            return redirect()->route('request.index', Auth::id())->with('error', trans('requests.error'));
        } else {
            $request = Borrow::create([
                'book_id' => $request->book_id,
                'user_id' => Auth::id(),
                'borrow_date' => $request->borrow_date,
                'return_date' => $request->return_date,
                'book_status' => 0,
            ]);
            if ($request) {
                $users = (new User)->where('role_id', config('app.role'))->get();
                
                $data = [
                    'user' => Auth::user()->name,
                    'content' => Auth::user()->name.' want to borrow '.$book->book_title,
                    'time' => date("d-m-Y H:i:s"),
                    'title' => 'BORROW REQUEST',
                    'link' => route('requests.showone', $request->borrow_id),
                ];
                foreach ($users as $user) {
                    $user->notify(new BorrowNotification($data));
                }
                $options = array(
                    'cluster' => 'ap1',
                    'encrypted' => true
                );

                $pusher = new Pusher(
                    env('PUSHER_APP_KEY'),
                    env('PUSHER_APP_SECRET'),
                    env('PUSHER_APP_ID'),
                    $options
                );

                $pusher->trigger('NotificationEvent', 'send-message', $data);

                return redirect()->route('request.index', Auth::id())
                        ->with('create_success', trans('user.request.create_success'));
            } else {
                return redirect()->route('request.index', Auth::id())
                        ->with('error', trans('request.fail'));
            }
        }
    }

    public function showone($id)
    {
        $categories = $this->categoryRepository->getCateParent();

        $borrow = $this->borrowRepository->find($id);
        if ($borrow) {
            return view('user.requests.showone', compact(['categories', 'borrow']));
        } else {
            return abort(404);
        }
    }

    public function index($user_id)
    {
        $categories = $this->categoryRepository->getCateParent();
        $borrows = $this->borrowRepository->getBorrowsByUsers($user_id);

        return view('user.requests.index', compact(['categories', 'borrows']));
    }
}
