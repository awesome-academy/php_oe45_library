<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\Category;
use DB;

class RequestController extends Controller
{
    public function indexRequest($borrow_status)
    {
        $categories = Category::whereNull('parent_id')->get();

        if ($borrow_status == config('app.unapproved') || $borrow_status == config('app.approved')) {
            $borrows = DB::table('borrows')
                    ->where('borrow_status', $borrow_status)
                    ->join('books', 'books.book_id', '=', 'borrows.book_id')
                    ->join('users', 'users.user_id', '=', 'borrows.user_id')
                    ->paginate(config('app.paginate'));
        } elseif ($borrow_status == config('app.rejected')) {
            $borrows = DB::table('borrows')
                    ->where('borrow_status', $borrow_status)
                    ->join('books', 'books.book_id', '=', 'borrows.book_id')
                    ->join('users', 'users.user_id', '=', 'borrows.user_id')
                    ->paginate(config('app.paginate'));
        } else {
            $borrows = DB::table('borrows')
                    ->join('books', 'books.book_id', '=', 'borrows.book_id')
                    ->join('users', 'users.user_id', '=', 'borrows.user_id')
                    ->paginate(config('app.paginate'));
        }

        return view('admin.requests.index', compact(['categories', 'borrows']));
    }

    public function approved($borrow_id)
    {
        DB::table('borrows')->where('borrow_id', $borrow_id)->update(['borrow_status'=>config('app.approved')]);

        return redirect()->route('user_request.index', ['borrow_status' => config('app.approved')])
                         ->with('approved_success', trans('message.approved_success'));
    }

    public function rejected($borrow_id)
    {
        DB::table('borrows')->where('borrow_id', $borrow_id)
                            ->update(['borrow_status'=>config('app.rejected')]);

        return redirect()->route('user_request.index', ['borrow_status' => config('app.rejected')])
                         ->with('rejected_success', trans('message.rejected_success'));
    }

    public function destroy($borrow_id)
    {
        DB::table('borrows')->where('borrow_id', $borrow_id)->delete();

        return redirect()->route('user_request.index', ['borrow_status' => config('app.both')])
                         ->with('del_success', trans('message.del_success'));
    }
}
