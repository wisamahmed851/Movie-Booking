<?php

// CinemaSeat Model
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CinemaSeat extends Model
{
    use HasFactory;

    protected $table = 'cinema_seats';

    protected $fillable = [
        'cinema_id',
        'cinema_seats_categories_id',
        'seat_number',
        'status'
    ];

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    public function seatCategory()
    {
        return $this->belongsTo(CinemaSeatsCategories::class, 'cinema_seats_categories_id');
    }
}

