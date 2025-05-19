<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Notification; // Assuming you have a Notification model

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // recipient
            $table->string('title');             // short title for the notification
            $table->text('message');             // full message
            $table->string('type')->default('info'); // e.g., info, alert, reminder
            $table->boolean('is_read')->default(false); // read/unread status
            $table->timestamps();                // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
