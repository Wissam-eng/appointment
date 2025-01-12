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
        Schema::create('stock', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('product_img')->nullable();
            $table->string('product_type'); 
            $table->text('note')->nullable();
            $table->integer('qty');
            $table->decimal('price', 8, 2);
            $table->date('exp_date');
            $table->integer('facility_id');
            $table->integer('category_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock');
    }
};
