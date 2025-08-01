<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;
    protected $table = 'foods';
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'stock',
        'food_category_id',
        'admin_id',
        
        
        
        
    ];
    public function FoodCategory()
    {
        return $this->belongsTo(FoodCategory::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function ticketFoods()
    {
        return $this->hasMany(TicketFood::class);
    }
}
