<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
   
    protected $fillable = [
        'title',
        'admin_id',
    ];
      

    
     

   
     public function Movies()
    {
        return $this->hasMany(Movie::class);
    }
    public function Admin()
    {
        return $this->belongsTo(Admin::class);
    }
    
}
