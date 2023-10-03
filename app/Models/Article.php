<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    function user()
    {
        $this->belongsTo(User::class, 'user_id');
    }

    function category()
    {
        $this->belongsTo(Category::class, 'category_id');
    }
}
