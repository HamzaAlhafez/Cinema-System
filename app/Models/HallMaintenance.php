<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HallMaintenance extends Model
{
    use HasFactory;
    protected $fillable = [
        'hall_id',     
        'employee_id', 
        'start_date',  
        'notes'        
    ];
    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
