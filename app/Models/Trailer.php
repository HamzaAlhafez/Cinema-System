<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trailer extends Model
{
    use HasFactory;
    protected $fillable = [
        'trailer_url',
        'movie_id',
        'admin_id',
        

    ];
    public function movie()
    {
      return $this->belongsTo(Movie::class);
    }
    public function Admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function EmbedUrl()
{
    $url = $this->trailer_url;

    // اليوتيوب: الصيغة العادية
    if (str_contains($url, 'youtube.com/watch?v=')) {
        return str_replace('watch?v=', 'embed/', $url);
    }

    // اليوتيوب: الصيغة المختصرة
    if (str_contains($url, 'youtu.be/')) {
        $path = parse_url($url, PHP_URL_PATH);
        $videoId = trim($path, '/');
        return "https://www.youtube.com/embed/{$videoId}";
    }

   

    // إذا كان الرابط من نوع التضمين مسبقاً أو منصة أخرى، نرجعه كما هو
    return $url;
}
   
    
}
