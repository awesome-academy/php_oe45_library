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

class RequestController extends Controller
{
    public function indexRequest($borrow_status)
    {
        $categories = Category::whereNull('parent_id')->get();

        if ($borrow_status == config('app.unapproved') || $borrow_status == config('app.approved')) {
            $borrows = Borrow::with(['book', 'user'])
                       ->latest()
                       ->where('borrow_status', $borrow_status)
                       ->paginate(config('app.paginate'));
        } elseif ($borrow_status == config('app.rejected')) {
            $borrows = Borrow::with(['book', 'user'])
                       ->latest()
                       ->where('borrow_status', $borrow_status)
                       ->paginate(config('app.paginate'));
        } else {
            $borrows = Borrow::with(['book', 'user'])
                       ->latest()
                       ->paginate(config('app.paginate'));
        }

        return view('admin.requests.index', compact(['categories', 'borrows']));
    }

    public function approved($borrow_id)
    {
        DB::table('borrows')->where('borrow_id', $borrow_id)->update(['borrow_status'=>config('app.approved')]);
        $borrow = Borrow::with(['book', 'user'])->where('borrow_id', $borrow_id)->first();
        
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
        DB::table('borrows')->where('borrow_id', $borrow_id)
                            ->update(['borrow_status'=>config('app.rejected')]);
        $borrow = Borrow::with(['book', 'user'])->where('borrow_id', $borrow_id)->first();

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
        $borrow = Borrow::find($id);
        if ($borrow) {
            return view('admin.requests.showone', compact('borrow'));
        } else {
            return abort(404);
        }
    }

    public function destroy($borrow_id)
    {
        DB::table('borrows')->where('borrow_id', $borrow_id)->delete();

        return redirect()->route('user_request.index', ['borrow_status' => config('app.both')])
                         ->with('del_success', trans('message.del_success'));
    }
}
