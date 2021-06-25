<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Book;
use App\Models\Authorfollow;

class Borrow extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'author_id';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'author_name',
        'author_desc',
    ];

    public function books()
    {
        return $this->hasMany(Book::class, 'author_id');
    }

    public function authorfollows()
    {
        return $this->hasMany(Authorfollow::class, 'author_id');
    }

}