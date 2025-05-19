<?php

namespace App\Http\Controllers;

use App\Models\SpecialRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpecialRequestController extends Controller
{
    // POST /special-requests - Submit a special request for a reservation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'request_details' => 'required|string|max:1000',
        ]);

        // Only allow user to submit for their own reservation
        $userId = Auth::id();
        $reservation = \App\Models\Reservation::where('id', $validated['reservation_id'])
            ->where('user_id', $userId)
            ->first();

        if (!$reservation) {
            return response()->json(['error' => 'Unauthorized or reservation not found'], 403);
        }

        $specialRequest = SpecialRequest::create([
            'reservation_id' => $validated['reservation_id'],
            'request_details' => $validated['request_details'],
            'status' => 'pending',
        ]);

        return response()->json($specialRequest, 201);
    }

    // GET /special-requests/{reservation_id} - View special requests for a reservation
    public function showByReservation($reservationId)
    {
        $userId = Auth::id();
        $reservation = \App\Models\Reservation::where('id', $reservationId)
            ->where('user_id', $userId)
            ->first();

        if (!$reservation) {
            return response()->json(['error' => 'Unauthorized or reservation not found'], 403);
        }

        $requests = SpecialRequest::where('reservation_id', $reservationId)->get();

        return response()->json($requests);
    }

    // PUT /special-requests/{id}/status - Update request status (admin)
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $specialRequest = SpecialRequest::findOrFail($id);

        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $specialRequest->status = $validated['status'];
        $specialRequest->save();

        return response()->json(['message' => 'Status updated successfully', 'data' => $specialRequest]);
    }
}
