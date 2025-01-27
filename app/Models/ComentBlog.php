<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentBlog extends Model
{
    //\
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'coment_blogs';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'blog_id',
        'name',
        'email',
        'coment',
        'approved',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'approved' => 'integer',
    ];

    /**
     * Relationship: A comment belongs to a blog.
     */
    public function blog()
    {
        return $this->belongsTo(Blogs::class, 'blog_id');
    }
}
