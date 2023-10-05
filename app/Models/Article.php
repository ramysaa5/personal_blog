<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // function getImageAttribute()
    // {
    //     $img = asset('images/image_not_found.jpg');
    //     if (file_exists(public_path('images/' . $this->imageUrl))) {
    //         $img = asset('images/' . $this->imageUrl);
    //     }
    //     return $img;
    // }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: function () {
                $img = null; // Initialize to null

                if (!empty($this->imageUrl) && file_exists(public_path('images/' . $this->imageUrl))) {
                    $img = asset('images/' . $this->imageUrl);
                } else {
                    $img = asset('images/Image_not_available.png');
                }

                return $img;
            }
        );
    }
}
