<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bookings extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $table = 'bookings';

    protected $fillable = [
        'user_id',
        'total_price',
        'booking_date',
        'assign_movies_details_id',
        'status',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with AssignMoviesDetails
    public function assignMoviesDetails()
    {
        return $this->belongsTo(AssignMoviesDetails::class, 'assign_movies_details_id');
    }

    // Relationship with BookingDetails
    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class);
    }
}
