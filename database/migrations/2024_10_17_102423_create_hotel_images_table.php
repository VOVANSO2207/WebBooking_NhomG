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
        Schema::disableForeignKeyConstraints();

        Schema::create('hotel_images', function (Blueprint $table) {
            $table->increments('image_id');
            $table->integer('hotel_id');
            $table->char('image_url');
            $table->foreign('image_url')->references('hotel_id')->on('hotels');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_images');
    }
};
