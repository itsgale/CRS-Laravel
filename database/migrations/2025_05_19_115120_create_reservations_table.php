<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Reservation;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // customer who made the reservation
            $table->foreignId('catering_service_id')->constrained()->onDelete('cascade'); // selected catering service
            $table->date('reservation_date');         // date of event
            $table->time('reservation_time');         // time of event
            $table->integer('guest_count');           // number of guests
            $table->string('location');               // event location
            $table->string('status')->default('pending'); // pending, confirmed, cancelled, completed
            $table->timestamps();                     // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
