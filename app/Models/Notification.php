<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Define fillable attributes (columns in your notifications table)
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',             // e.g., info, alert, reminder
        'is_read',          // boolean: true if user has read it
    ];

    // A notification belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A notification may be related to a reservation
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
