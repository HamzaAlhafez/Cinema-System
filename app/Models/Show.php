<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    use HasFactory;
     protected $fillable = [
        'movie_id',
        'hall_id',
        'admin_id',
        'price',
        'date',
        'start_time',
        'end_time',
        'remaining_seats',
        
    ];
     protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
     public function hall()
    {
        return $this->belongsTo(Hall::class);
    }
     public function Admin()
    {
        return $this->belongsTo(Admin::class);
    }

    

}
