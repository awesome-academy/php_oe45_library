<?php

namespace App\Repositories;

use App\Models\Borrow;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\RepositoryInterface\BorrowRepositoryInterface;

class BorrowRepository extends BaseRepository implements BorrowRepositoryInterface
{

    public function getModel()
    {
        return Borrow::class;
    }

    public function getUncheckedBorrow()
    {
        return Borrow::where('borrow_status', config('app.unapproved'))->count();
    }

    public function getBorrowsByStatus($borrow_status)
    {
        return Borrow::with(['book', 'user'])
                       ->latest()
                       ->where('borrow_status', $borrow_status)
                       ->paginate(config('app.paginate'));
    }

    public function getAllBorrows()
    {
        return Borrow::with(['book', 'user'])
                       ->latest()
                       ->paginate(config('app.paginate'));
    }

    public function getBorrowsByUsers($user_id)
    {
        return Borrow::with(['user', 'book'])
                   ->where('user_id', $user_id)
                   ->latest()
                   ->paginate(config('app.paginate'));
    }

    public function approveBorrow($borrow_id)
    {
        return DB::table('borrows')
                ->where('borrow_id', $borrow_id)
                ->update(['borrow_status'=>config('app.approved')]);
    }

    public function rejectBorrow($borrow_id)
    {
        return DB::table('borrows')
                ->where('borrow_id', $borrow_id)
                ->update(['borrow_status'=>config('app.rejected')]);
    }

    public function getBorrowWithBookUser($borrow_id)
    {
        return Borrow::with(['book', 'user'])
                ->where('borrow_id', $borrow_id)
                ->first();
    }

    public function getSameBorrow($id)
    {
        return (new Borrow)->where([['book_id', $id], ['user_id', Auth::id()]])->first();
    }
}
