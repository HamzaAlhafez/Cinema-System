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
        'employee_id',
        'Seats_Booked',
        'tickets_Price',
        'Booking_Status',
        'rated',
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
    public function Employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function seatReservations()
    {
        return $this->hasMany(SeatReservation::class);
    }
    public function foods()
{
    return $this->hasMany(TicketFood::class);
}
public function rating()
{
    return $this->hasOne(Rating::class);
}
    
  
}
