<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Book;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'cate_id';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'cate_name',
        'cate_desc',
        'parent_id',
    ];

    public function books()
    {
        return $this->hasMany(Book::class, 'cate_id');
    }

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
