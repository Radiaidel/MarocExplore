<?php

namespace App\Http\Controllers;

use App\Models\Itineraire ;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ItineraireController extends Controller
{
    public function index(Request $request)
    {
        $itineraries = Itineraire::query();

        if ($request->has('category')) {
            $itineraries->where('category', $request->category);
        }

        if ($request->has('duration')) {
            $itineraries->where('duration', $request->duration);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $itineraries->where('title', 'like', "%$search%");
        }

        return response()->json($itineraries);
    }

    public function show(Itineraire $itinerary)
    {
        return response()->json($itinerary);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'category' => 'required|string',
            'duration' => 'required|string',
            'destinations' => 'required|array|min:2',
            'destinations.*.name' => 'required|string',
            'destinations.*.accommodation' => 'required|string',
            'destinations.*.activities' => 'required|array|min:1',
            'destinations.*.places_to_visit' => 'required|array|min:1',
            'destinations.*.dishes_to_try' => 'required|array|min:1',
        ]);
    
        $user = Auth::user();
    
        $itinerary = $user->itineraries()->create([
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'duration' => $request->input('duration'),
        ]);
    
        foreach ($request->destinations as $destinationData) {
            $activities = json_encode($destinationData['activities']);
            $places_to_visit = json_encode($destinationData['places_to_visit']);
            $dishes_to_try = json_encode($destinationData['dishes_to_try']);
    
            $itinerary->destinations()->create([
                'name' => $destinationData['name'],
                'accommodation' => $destinationData['accommodation'],
                'activities' => $activities,
                'places_to_visit' => $places_to_visit,
                'dishes_to_try' => $dishes_to_try,
            ]);
        }
    
        return response()->json($itinerary, 201);
    }
    
    

    public function update(Request $request, Itinerary $itinerary)
    {
        $request->validate([
            'title' => 'required|string',
            'category' => 'required|string',
            'duration' => 'required|string',
            'destinations' => 'required|array|min:2',
            'destinations.*.name' => 'required|string',
            'destinations.*.accommodation' => 'required|string',
            'destinations.*.activities' => 'required|array|min:1',
            'destinations.*.places_to_visit' => 'required|array|min:1',
            'destinations.*.dishes_to_try' => 'required|array|min:1',
        ]);

        $this->authorize('update', $itinerary);

        $itinerary->update($request->only('title', 'category', 'duration'));

        $itinerary->destinations()->delete();
        $itinerary->destinations()->createMany($request->destinations);

        return response()->json($itinerary);
    }

    public function destroy(Itinerary $itinerary)
    {
        $this->authorize('delete', $itinerary);

        $itinerary->delete();

        return response()->json(['message' => 'Itinerary deleted']);
    }

    public function addToWishlist(Itinerary $itinerary)
    {
        $user = Auth::user();
        $user->wishlist->attach($itinerary->id);

        return response()->json(['message' => 'Itinerary added to wishlist']);
    }
}