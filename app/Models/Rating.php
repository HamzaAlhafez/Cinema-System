<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_id',
        'user_id',
        'movie_quality',
        'hall_cleanliness',
        'seat_comfort',
        'sound_quality',
        'screen_quality',
        'food_quality',
        'staff_behavior',
        'overall_experience',
        'comments',
    ];
    public function ticket()
{
    return $this->belongsTo(Ticket::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}

}
