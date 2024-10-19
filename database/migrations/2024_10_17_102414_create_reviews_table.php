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
        
        Schema::create('reviews', function (Blueprint $table) {
            $table->integer('review_id')->autoIncrement();
            $table->foreign('review_id')->references('hotel_id')->on('hotels');
            $table->integer('hotel_id');
            $table->foreign('hotel_id')->references('user_id')->on('user');
            $table->integer('user_id');
            $table->decimal('rating');
            $table->text('comment');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
