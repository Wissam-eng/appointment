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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
          
            $table->integer('floor_num');
            $table->integer('dep_id')->nullable();
            $table->integer('room_class');
            $table->integer('facility_id');
            $table->integer('facility_type')->nullable();
            $table->integer('patients_booke')->default(0);
            $table->integer('is_booked')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
