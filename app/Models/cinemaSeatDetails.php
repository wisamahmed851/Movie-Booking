<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cinemaSeatDetails extends Model
{
    //
    use HasFactory;

    // Explicitly define the table name
    protected $table = 'cinema_seats_details';

    protected $fillable = ['cinema_id', 'seat_category_id', 'seats_row', 'seat_number'];

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    public function seatCategory()
    {
        return $this->belongsTo(SeatCategory::class, 'seat_category_id');
    }

    public function seats()
    {
        return $this->hasMany(CinemaSeat::class, 'cinema_seats_details_id');
    }
}
