<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',



    ];


    protected $hidden = [
        'password',

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
     public function Mangers()
    {
        return $this->hasMany(Manger::class);

    }



     public function Movies()
    {
        return $this->hasMany(Movie::class);
    }

    public function halls()
    {
        return $this->hasMany(Hall::class);
    }

    public function shows()
    {
        return $this->hasMany(Show::class);
    }
}
