<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;
    
    protected $fillable = ['url', 'short_url', 'user_id', 'expires_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }
    
    public static function deleteExpiredShortLinks()
    {
        $expiredLinks = Link::where('expires_at', '<=', now())->get();
        foreach ($expiredLinks as $link) {
            $link->delete();
        }
    }
}
