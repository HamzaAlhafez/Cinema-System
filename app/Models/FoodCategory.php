<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'admin_id',
        
        
    ];
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function foods()
    {
        return $this->hasMany(Food::class);
    }
}
