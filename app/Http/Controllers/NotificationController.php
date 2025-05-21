<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // GET /notifications - List all notifications for logged-in user
    public function index()
    {
        $userId = Auth::id();
        $notifications = Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($notifications);
    }

    // POST /notifications - Create a notification (typically by admin or system)
    public function store(Request $request)
    {
        // Only admins can create notifications
        if (Auth::user()->role_id != 1) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $notification = Notification::create([
            'user_id' => $validated['user_id'],
            'title' => $validated['title'],
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        return response()->json($notification, 201);
    }

    // PUT /notifications/{id}/read - Mark notification as read
    public function markAsRead($id)
    {
        $userId = Auth::id();
        $notification = Notification::where('id', $id)->where('user_id', $userId)->first();

        if (!$notification) {
            return response()->json(['error' => 'Notification not found or unauthorized'], 404);
        }

        $notification->is_read = true;
        $notification->save();

        return response()->json(['message' => 'Notification marked as read']);
    }

    // DELETE /notifications/{id} - Delete a notification
    public function destroy($id)
    {
        $userId = Auth::id();
        $notification = Notification::where('id', $id)->where('user_id', $userId)->first();

        if (!$notification) {
            return response()->json(['error' => 'Notification not found or unauthorized'], 404);
        }

        $notification->delete();

        return response()->json(['message' => 'Notification deleted']);
    }
}
