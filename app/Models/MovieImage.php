<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieImage extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'cover_image_path',
        'banner_image_path',
        'slider_images',
    ];

    protected $casts = [
        'slider_images' => 'array', // Cast slider_images to an array
    ];
    // If a movie references this image as a cover image
    public function coverForMovie()
    {
        return $this->hasOne(Movie::class, 'cover_image_id');
    }

    // If a movie references this image as a banner image
    public function bannerForMovie()
    {
        return $this->hasOne(Movie::class, 'banner_image_id');
    }

    // If a movie references this image as slider images
    public function sliderForMovie()
    {
        return $this->hasOne(Movie::class, 'slider_image_id');
    }
}
