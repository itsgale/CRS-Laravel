<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CateringService extends Model
{
    use HasFactory;

    // Define fillable attributes (columns in your catering_services table)
    protected $fillable = [
        'name',
        'description',
        'price',
        'category', // e.g., buffet, set meal, custom
        'status',   // e.g., available, unavailable
    ];

    // A catering service can be linked to many reservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
