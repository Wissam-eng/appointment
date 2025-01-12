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
        Schema::create('rooms_classes', function (Blueprint $table) {
            $table->id();
            $table->string('roomsClass_name');
            $table->integer('price_day');
            $table->integer('facility_id');
            $table->integer('number_companions');
            $table->integer('number_beds');
            $table->integer('room_type')->nullable();
            $table->integer('room_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms_classes');
    }
};
