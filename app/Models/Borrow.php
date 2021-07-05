<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Book;

class Borrow extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'borrow_id';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'book_id',
        'borrow_status',
        'borrow_date',
        'return_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}
