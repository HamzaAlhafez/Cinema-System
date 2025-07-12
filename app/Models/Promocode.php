<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'type',
        'description',
        'value',
        'expiry_date',
        'max_usage',
        'used_count',
        'points_required',
        'max_usage_per_user',
        'is_active',
        'admin_id',
        

    ];
    protected $casts = [
        'expiry_date' => 'date',
       
    ];
   
   
    public static function allowedTypes(): array
    {
        return ['discount'];
    }
    public function Promocodeusage()
    {
        return $this->hasMany(Promocodeusage::class);
    }
    public function users()
{
    return $this->belongsToMany(User::class, 'promocodeusages', 'promocode_id', 'user_id')
                ->withTimestamps();
}
public function Purchasepromocodes()
{
    return $this->hasMany(Purchasepromocode::class);
}
public function Admin()
    {
        return $this->belongsTo(Admin::class);
    }
   

}
