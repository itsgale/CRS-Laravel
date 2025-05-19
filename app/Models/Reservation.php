<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // Define fillable attributes (columns in your reservations table)
    protected $fillable = [
        'user_id',
        'catering_service_id',
        'reservation_date',
        'event_time',
        'event_location',
        'guest_count',
        'status', // e.g., pending, confirmed, cancelled
    ];

    // A reservation belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A reservation is for one catering service
    public function cateringService()
    {
        return $this->belongsTo(CateringService::class);
    }

    // A reservation has one payment
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // A reservation can have many special requests
    public function specialRequests()
    {
        return $this->hasMany(SpecialRequest::class);
    }
}
