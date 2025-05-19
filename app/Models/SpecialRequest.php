<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialRequest extends Model
{
    use HasFactory;

    // Define fillable attributes (columns in your special_requests table)
    protected $fillable = [
        'reservation_id',
        'request_detail',
        'status', // e.g., pending, approved, rejected
    ];

    // A special request belongs to one reservation
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
