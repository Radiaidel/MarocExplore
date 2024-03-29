<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itineraire extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'category', 'duration', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function destinations()
    {
        return $this->hasMany(Destination::class);
    }
    public function wishlist()
{
    return $this->belongsToMany(User::class, 'wishlists', 'itineraire_id', 'user_id');
}
}
