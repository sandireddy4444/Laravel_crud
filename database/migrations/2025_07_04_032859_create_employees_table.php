<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration { 
    public function up(): void { 
        Schema::create('employees', function (Blueprint $table) {
            $table->id(); // Integer: Auto-incrementing ID 
            $table->string('name'); // String: Employee name 
            $table->string('email')->unique(); // String: Unique email
            $table->text('description')->nullable(); // Text: Description 
            $table->boolean('is_active')->default(true); // Boolean: Active status 
            $table->enum('gender', ['male', 'female', 'other'])->nullable(); // Enum: Gender 
            $table->string('profile_picture')->nullable(); // String: File path for profile picture 
            $table->json('preferences')->nullable(); // JSON: For checkbox preferences 
            $table->enum('status', ['full_time', 'part_time', 'contract'])->default('full_time'); // Enum: Radio button status 
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign Key: References users table 
            $table->timestamps(); // DateTime: created_at, updated_at 
            }); }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
