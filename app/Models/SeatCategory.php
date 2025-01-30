<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatCategory extends Model
{
    //
    use HasFactory;

    protected $fillable = ['name', 'price'];

    public function seatDetails()
    {
        return $this->hasMany(cinemaSeatDetails::class, 'seat_category_id');
    }
}
