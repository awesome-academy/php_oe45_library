<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Publisher;
use App\Models\Author;
use App\Models\Category;
use App\Models\Borrow;
use App\Models\Like;
use App\Models\Review;
use App\Models\Bookfollow;

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'book_id';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'book_title',
        'book_img',
        'cate_id',
        'author_id',
        'pub_id',
        'quantity',
        'book_desc',
    ];

    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'pub_id');
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'cate_id');
    }

    public function borrows()
    {
        return $this->hasMany(Borrow::class, 'book_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'book_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'book_id');
    }

    public function bookfollows()
    {
        return $this->hasMany(Bookfollow::class, 'book_id');
    }
}
