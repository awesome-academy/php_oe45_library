<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\Category;
use App\Models\User;
use App\Notifications\BorrowNotification;
use Illuminate\Support\Facades\Auth;
use DB;
use Pusher\Pusher;
use App\Repositories\RepositoryInterface\BorrowRepositoryInterface;
use App\Repositories\RepositoryInterface\CategoryRepositoryInterface;

class RequestController extends Controller
{
    private $borrowRepository;
    
    public function __construct(
        BorrowRepositoryInterface $borrowRepository
    ) {
        $this->borrowRepository = $borrowRepository;
    }

    public function indexRequest($borrow_status)
    {
        if ($borrow_status == config('app.unapproved') || $borrow_status == config('app.approved')) {
            $borrows = $this->borrowRepository->getBorrowsByStatus($borrow_status);
        } elseif ($borrow_status == config('app.rejected')) {
            $borrows = $this->borrowRepository->getBorrowsByStatus($borrow_status);
        } else {
            $borrows = $this->borrowRepository->getAllBorrows();
        }

        return view('admin.requests.index', compact('borrows'));
    }

    public function approved($borrow_id)
    {
        $this->borrowRepository->approveBorrow($borrow_id);
        $borrow = $this->borrowRepository->getBorrowWithBookUser($borrow_id);
        
        if ($borrow) {
            $user = $borrow->user;
            $data = [
                'user' => Auth::user()->name,
                'content' => Auth::user()->name.' accepted you borrow '.$borrow->book->book_title,
                'time' => date("d-m-Y H:i:s"),
                'title' => 'ACCEPTED BORROW',
                'link' => route('request.showone', [$borrow->borrow_id]),
            ];
            $user->notify(new BorrowNotification($data));
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

            $pusher->trigger('NotificationEvent', 'send-message-user', $data);

            return redirect()->route('user_request.index', ['borrow_status' => config('app.approved')])
            ->with('approved_success', trans('message.approved_success'));
        } else {
            return redirect()->route('user_request.index', ['borrow_status' => config('app.approved')])
            ->with('error', trans('request.fail'));
        }
    }

    public function rejected($borrow_id)
    {
        $this->borrowRepository->rejectBorrow($borrow_id);
        $borrow = $this->borrowRepository->getBorrowWithBookUser($borrow_id);

        if ($borrow) {
            $user = $borrow->user;
            $data = [
                'user' => Auth::user()->name,
                'content' => Auth::user()->name.' rejected you borrow '.$borrow->book->book_title,
                'time' => date("d-m-Y H:i:s"),
                'title' => 'REJECTED BORROW',
                'link' => route('request.showone', [$borrow->borrow_id]),
            ];
            $user->notify(new BorrowNotification($data));
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

            $pusher->trigger('NotificationEvent', 'send-message-user', $data);

            return redirect()->route('user_request.index', ['borrow_status' => config('app.rejected')])
            ->with('rejected_success', trans('message.rejected_success'));
        } else {
            return redirect()->route('user_request.index', ['borrow_status' => config('app.approved')])
            ->with('error', trans('request.fail'));
        }
    }

    public function showone($id)
    {
        $borrow = $this->borrowRepository->find($id);
        if ($borrow) {
            return view('admin.requests.showone', compact('borrow'));
        } else {
            return abort(404);
        }
    }

    public function destroy($borrow_id)
    {
        $this->borrowRepository->delete($borrow_id);

        return redirect()->route('user_request.index', ['borrow_status' => config('app.both')])
                         ->with('del_success', trans('message.del_success'));
    }
}
