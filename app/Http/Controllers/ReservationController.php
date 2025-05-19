<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // GET /reservations - list all reservations (user-specific or admin)
    public function index()
    {
        $user = Auth::user();

        // Admin can see all, users only their own
        $reservations = $user->role === 'admin'
            ? Reservation::all()
            : Reservation::where('user_id', $user->id)->get();

        return response()->json($reservations);
    }

    // POST /reservations - create new reservation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'catering_service_id' => 'required|exists:catering_services,id',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'guest_count' => 'required|integer|min:1',
            'location' => 'required|string',
        ]);

        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'catering_service_id' => $validated['catering_service_id'],
            'reservation_date' => $validated['reservation_date'],
            'reservation_time' => $validated['reservation_time'],
            'guest_count' => $validated['guest_count'],
            'location' => $validated['location'],
            'status' => 'pending',
        ]);

        return response()->json($reservation, 201);
    }

    // GET /reservations/{id} - view single reservation
    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);
        $user = Auth::user();

        if ($user->id !== $reservation->user_id && $user->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($reservation);
    }

    // PUT /reservations/{id} - update reservation
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $user = Auth::user();

        if ($user->id !== $reservation->user_id && $user->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'reservation_date' => 'sometimes|date',
            'reservation_time' => 'sometimes',
            'guest_count' => 'sometimes|integer|min:1',
            'location' => 'sometimes|string',
            'status' => 'sometimes|string|in:pending,confirmed,cancelled,completed',
        ]);

        $reservation->update($validated);

        return response()->json($reservation);
    }

    // DELETE /reservations/{id} - cancel or delete reservation
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $user = Auth::user();

        if ($user->id !== $reservation->user_id && $user->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $reservation->delete();

        return response()->json(['message' => 'Reservation deleted']);
    }
}
