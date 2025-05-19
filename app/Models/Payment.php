<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Define fillable attributes (columns in your payments table)
    protected $fillable = [
        'reservation_id',
        'amount',
        'payment_method',   // e.g., credit_card, cash, online
        'payment_status',   // e.g., paid, pending, failed
        'payment_date',
    ];

    // A payment belongs to one reservation
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
