<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Authenticatable
{
    use HasFactory;
    protected $table = 'employees';
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
    public function Ticket()
    {
        return $this->hasMany(Ticket::class);
    }
   


    
}
