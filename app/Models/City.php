<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    use HasFactory;

    protected $table = 'cities';
    protected $fillable = [
        'name',
        'country_id',
        'status',
    ];


    public function cinemas()
    {
        return $this->hasMany(Cinema::class);
    }

    /**
     * Relationships: If a language can be associated with multiple movies,
     * you can define the relationship here.
     */

}
