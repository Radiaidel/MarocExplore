<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Itineraire as Itinerary;

class Wishlist extends Model
{
    protected $fillable = [
        'user_id', 'itineraire_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class);
    }
}
