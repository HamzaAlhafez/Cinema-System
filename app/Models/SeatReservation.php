<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatReservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'seat_number',
        'show_id',
        'ticket_id',


    ];

    public function show()
    {
        return $this->belongsTo(Show::class);
    }
    public function ticket()
{
    return $this->belongsTo(Ticket::class);
}
 

}
