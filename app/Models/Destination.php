<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Itineraire as Itinerary;

class Destination extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'accommodation', 'places_to_visit', 'activities', 'dishes_to_try', 'itineraire_id'
    ];
    

    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class);
    }
}
