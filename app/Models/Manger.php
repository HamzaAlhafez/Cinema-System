<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manger extends Model
{
    use HasFactory;
     protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'admin_id',
        
        
    ];
    public function Admin()
    {
        return $this->belongsTo(Admin::class);
    }
   


    
}
