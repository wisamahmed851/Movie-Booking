<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogDetails extends Model
{
    //
    protected $table = 'blog_details';
    protected $fillable = [
        'blog_id',
        'short_description',
        'cover_image',
        'long_description'
    ];

    public function blog(){
        return $this->belongsTo(Blogs::class, 'blog_id');
    }
}
