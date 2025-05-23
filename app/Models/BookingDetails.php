<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'booking_details';

    protected $fillable = [
        'booking_id',
        'seat_id',
        'cinema_seats_categories_id',
    ];

    // Relationship with Booking
    public function booking()
    {
        return $this->belongsTo(Bookings::class);
    }

    // Relationship with CinemaSeat
    public function cinemaSeat()
    {
        return $this->belongsTo(CinemaSeat::class);
    }
}
