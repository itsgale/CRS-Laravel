<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // POST /payments - Create a payment
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $reservation = Reservation::where('id', $validated['reservation_id'])
            ->where('user_id', $user->id)
            ->first();

        if (!$reservation) {
            return response()->json(['error' => 'Unauthorized or reservation not found'], 403);
        }

        $payment = Payment::create([
            'reservation_id' => $validated['reservation_id'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
            'payment_date' => now(),
        ]);

        return response()->json(['message' => 'Payment created', 'data' => $payment], 201);
    }

    // GET /payments/{reservation_id} - View payments for a reservation
    public function showByReservation($reservationId)
    {
        $user = Auth::user();
        $reservation = Reservation::where('id', $reservationId)
            ->where('user_id', $user->id)
            ->first();

        if (!$reservation) {
            return response()->json(['error' => 'Unauthorized or reservation not found'], 403);
        }

        $payments = Payment::where('reservation_id', $reservationId)->get();

        return response()->json($payments);
    }

    // PUT /payments/{id}/status - Update payment status (admin only)
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,cancelled',
        ]);

        $payment = Payment::findOrFail($id);

        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $payment->payment_status = $validated['payment_status'];
        $payment->save();

        return response()->json(['message' => 'Payment status updated', 'data' => $payment]);
    }
}
