<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchasepromocode extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'promocode_id',
        'purchased_at',
        
        

    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function Promocode()
    {
        return $this->belongsTo(Promocode::class);
    }

}
