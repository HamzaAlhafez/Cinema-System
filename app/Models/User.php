<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'loyalty_points',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function Ticket()
    {
        return $this->hasMany(Ticket::class);
    }
    public function LoyaltyTransaction()
    {
        return $this->hasMany(LoyaltyTransaction::class);
    }
    public function promocodes()
{
    return $this->belongsToMany(Promocode::class, 'promocodeusages', 'user_id', 'promocode_id')
                ->withTimestamps();
}
    
    public function Promocodeusage()
    {
        return $this->hasMany(Promocodeusage::class);
    }
    public function Purchasepromocodes()
    {
        return $this->hasMany(Purchasepromocode::class);
    }
}
