<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $roles = [
            ['name' => 'Admin'], // Full control over the system (manage users, reservations, settings, etc.)
            ['name' => 'Staff'], // Can manage or prepare catering orders, view reservations, but with limited access compared to admin.
            ['name' => 'Customer'], // Regular user who can make reservations and view their reservation status.


        ];

        foreach($roles as $role){
            Role::create($role);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
