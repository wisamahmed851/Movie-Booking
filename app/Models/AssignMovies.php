<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignMovies extends Model
{
    //
    use HasFactory;

    protected $table = 'assign_movies';
    protected $fillable = [
        'movie_id',
        'cinema_id',
        'status',
    ];

    // Relationship with AssignMoviesDetails
    public function details()
    {
        return $this->hasMany(AssignMoviesDetails::class, 'assign_movies_id');
    }

    // Relationship with Movie
    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }

    // Relationship with Cinema
    public function cinema()
    {
        return $this->belongsTo(Cinema::class, 'cinema_id');
    }
}
