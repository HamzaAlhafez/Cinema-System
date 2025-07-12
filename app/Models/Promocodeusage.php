<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocodeusage extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'promocode_id',
        
        

    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function Promocode()
    {
        return $this->belongsTo(Promocode::class);
    }
    
}
