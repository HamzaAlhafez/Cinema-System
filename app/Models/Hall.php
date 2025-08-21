<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;
     protected $fillable = ['hall_name','Capacity','admin_id',];

     
     
    public function shows()
    {
        return $this->hasMany(Show::class);
    }
    public function Admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function HallMaintenances()
    {
        return $this->hasMany(HallMaintenance::class);
    }
    
}
