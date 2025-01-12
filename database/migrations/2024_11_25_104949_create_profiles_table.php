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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('first_name')->nullable();
            $table->string('second_name')->nullable();
            $table->string('third_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('date_birth')->nullable();
            $table->integer('mobile')->nullable();
            $table->integer('old')->nullable();
            $table->integer('gender')->nullable();  
            $table->integer('martial_status')->nullable();  
            $table->integer('department_id')->nullable();  
            $table->string('nationality')->nullable();
            $table->string('certification')->nullable();
            $table->string('profile_pic')->nullable();
           $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
