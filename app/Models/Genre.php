<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];

    /**
     * Relationships: If a genre can be associated with multiple movies,
     * you can define the relationship here.
     */
    public function movies()
    {
        return $this->hasMany(Movie::class);
    }
}
