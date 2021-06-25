<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Book;

class Publisher extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'pub_id';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'pub_name',
        'pub_desc',
    ];

    public function books()
    {
        return $this->hasMany(Book::class, 'pub_id');
    }
}
