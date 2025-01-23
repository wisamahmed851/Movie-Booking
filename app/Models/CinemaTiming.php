<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CinemaTiming extends Model
{
    //

    protected $fillable = [
        'cinema_id',
        'start_time',
        'end_time',
        'status',
    ];

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    /**
     * Accessor: Return timing status as a label.
     */
    public function getStatusLabelAttribute()
    {
        return $this->status ? 'Active' : 'Inactive';
    }
}
