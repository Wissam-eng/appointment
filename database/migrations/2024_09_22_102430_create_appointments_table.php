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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id');
            $table->integer('room_type');
            $table->integer('user_id');
            $table->integer('old_child')->nullable();
            $table->integer('room_class')->nullable();
            $table->integer('surgery_type')->nullable();
            $table->integer('doctor')->nullable();
            $table->integer('Specialization')->nullable();
            $table->integer('facility_id');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('note');
            $table->integer('booking_data');
            $table->integer('status_booke');
            $table->integer('Dialysis_type');
            $table->integer('booking_type');
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
