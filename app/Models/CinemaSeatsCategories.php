<?php

// CinemaSeatsCategories Model
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CinemaSeatsCategories extends Model
{
    use HasFactory;

    protected $table = 'cinema_seats_categories';

    protected $fillable = [
        'cinema_id',
        'seat_category',
        'no_of_seats',
        'price_per_seat',
        'series_alphabet'
    ];

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    public function seats()
    {
        return $this->hasMany(CinemaSeat::class, 'cinema_seats_categories_id');
    }
}

