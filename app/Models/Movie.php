<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
     protected $fillable = [
        'categorie_id ', 'title', 'image', 'storyline',
        'rating', 'language', 'production_date', 'director',
         'Actors','admin_id',
    ];
     protected $casts = [
        'production_date' => 'date',
        
    ];
      
  


    public function Categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
     public function shows()
    {
        return $this->hasMany(Show::class);
    }
    public function Admin()
    {
        return $this->belongsTo(Admin::class);
    }
     
}
