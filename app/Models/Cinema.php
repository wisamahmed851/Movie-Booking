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
    
    public function getStatusLabelAttribute()
    {
        return $this->status ? 'Active' : 'Inactive';
    }

}
