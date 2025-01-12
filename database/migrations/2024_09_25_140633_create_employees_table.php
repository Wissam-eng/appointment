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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('second_name');
            $table->string('third_name');
            $table->string('last_name');
            $table->date('date_birth');
            $table->integer('mobile');
            $table->integer('old');
            $table->integer('gender');  
            $table->integer('martial_status');  
            $table->integer('department_id')->nullable();  
            $table->string('nationality');
            $table->string('certification');
            $table->string('position');
            $table->string('profile_pic')->nullable();
            $table->double('basic_salary', 8, 2);
            $table->double('commission', 8, 2);
            $table->time('duty_start');
            $table->time('duty_end');
            $table->dateTime('join_date');
            $table->integer('specialization_id');  
            $table->integer('Establishment_id');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
