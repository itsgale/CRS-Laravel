<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\CateringService;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('catering_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');                      // Name of the catering service
            $table->text('description');                 // Description of the service
            $table->decimal('price', 10, 2);             // Price of the service
            $table->string('category')->nullable();      // e.g., buffet, plated, etc.
            $table->string('status')->default('available'); // available/unavailable
            $table->timestamps();                        // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catering_services');
    }
};
