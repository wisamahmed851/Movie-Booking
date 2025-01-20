<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'genre_ids',
        'language_ids',
        'cover_image_id',
        'banner_image_id',
        'slider_image_id',
        'status',
        'trailler',
        'istrending',
        'isExclusive',
        'release_date',
        'duration',
    ];

    protected $casts = [
        'genre_ids' => 'array', // Cast genre IDs to an array
        'language_ids' => 'array', // Cast language IDs to an array
    ];

    public function bannerImage()
    {
        return $this->belongsTo(MovieImage::class, 'banner_image_id');
    }

    public function coverImage()
    {
        return $this->belongsTo(MovieImage::class, 'cover_image_id');
    }

    public function sliderImages()
    {
        return $this->belongsTo(MovieImage::class, 'slider_image_id');
    }
}
