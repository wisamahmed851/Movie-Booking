<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignMoviesDetails extends Model
{
    use HasFactory;

    protected $table = 'assign_movies_details';
    protected $fillable = [
        'assign_movies_id',
        'cinema_timings_id',
        'show_date',
    ];

    // Relationship with AssignMovie
    public function assignMovie()
    {
        return $this->belongsTo(AssignMovies::class, 'assign_movies_id');
    }

    // Relationship with CinemaTiming
    public function cinemaTiming()
    {
        return $this->belongsTo(CinemaTiming::class, 'cinema_timings_id');
    }
}