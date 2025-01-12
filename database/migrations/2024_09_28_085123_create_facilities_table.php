<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('mobile');
            $table->string('profile_pic')->nullable();
            $table->integer('room_num');
            $table->integer('facility_type');
            
            // Additional columns
            $table->float('Arrival_time')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('opening_hours')->nullable();
            $table->text('description')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->enum('status', ['active', 'inactive', 'under_maintenance'])->default('active');
            $table->integer('facility_class')->nullable();
            $table->foreignId('manager_id')->nullable()->constrained('users');
            $table->integer('capacity')->nullable();
            $table->string('services')->nullable();
            $table->string('license_number')->nullable();
            $table->date('established_at')->nullable();
            $table->text('analysis')->nullable();
            $table->text('ambulance')->nullable();
            $table->text('emergency')->nullable();
        
            $table->enum('Suggested', ['Suggested', 'unSuggested'])->default('unSuggested');
            
            // Soft delete and timestamps
            $table->softDeletes();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
