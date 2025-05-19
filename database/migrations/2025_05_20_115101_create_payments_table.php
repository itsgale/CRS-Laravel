<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Payment;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained()->onDelete('cascade'); // link to reservation
            $table->decimal('amount', 10, 2);                  // payment amount
            $table->string('payment_method');                 // e.g., GCash, PayPal, Cash
            $table->string('payment_status')->default('pending'); // e.g., paid, failed
            $table->date('payment_date')->nullable();         // when payment was made
            $table->timestamps();                             // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
