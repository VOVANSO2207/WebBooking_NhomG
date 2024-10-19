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

        Schema::create('favorite_hotels', function (Blueprint $table) {
            $table->increments('favorite_id');
            $table->foreign('favorite_id')->references('hotel_id')->on('hotels');
            $table->integer('user_id');
            $table->integer('hotel_id');
            $table->foreign('hotel_id')->references('user_id')->on('user');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_hotels');
    }
};
