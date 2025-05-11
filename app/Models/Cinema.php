<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'city_id',
        'status',
    ];

    public function timings()
    {
        return $this->hasMany(CinemaTiming::class);
    }
    public function CinemaSeatsCategories()
    {
        return $this->hasMany(CinemaSeatsCategories::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function assignMovies()
    {
        return $this->hasMany(AssignMovies::class);
    }
    public function assignMoviesDetails()
    {
        return $this->hasMany(AssignMoviesDetails::class);
    }
    public function getStatusLabelAttribute()
    {
        return $this->status ? 'Active' : 'Inactive';
    }

}
