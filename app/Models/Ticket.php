<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
     protected $fillable = [
        'show_id',
        'user_id',
        'Seats_Booked',
        'tickets_Price',
        'Booking_Status',
        'Booking_date',


    ];
     protected $casts = [
        'Booking_date' => 'date',

    ];

     public function show()
    {
        return $this->belongsTo(Show::class);
    }
     public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function seatReservations()
    {
        return $this->hasMany(SeatReservation::class);
    }
    
  
}
