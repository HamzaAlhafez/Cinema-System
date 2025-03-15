<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
    protected $fillable = ['title'];
     const CATEGORIES = ['Action', 'Drama', 'Comedy', 'Romance', 'Horror'];

   
     public function Movies()
    {
        return $this->hasMany(Movie::class);
    }
}
