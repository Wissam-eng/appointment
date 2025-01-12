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
        Schema::create('rooms_booking', function (Blueprint $table) {
            $table->id();
            $table->integer('room_id');
            $table->integer('patient_id');
            $table->integer('appappointment_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('payment_status')->default('pending'); 
            $table->integer('patients_booked');
            $table->integer('is_booked');
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms_booking');
    }
};
