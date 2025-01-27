<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    //
    protected $table = 'blogs';
    protected $fillable = [
        'title',
        'status'
    ];

    public function blogDetails()
    {
        return $this->hasOne(BlogDetails::class, 'blog_id');
    }
    public function comments()
    {
        return $this->hasMany(ComentBlog::class, 'blog_id');
    }
}
