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

        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('booking_id');
            $table->foreign('booking_id')->references('user_id')->on('user');
            $table->integer('user_id');
            $table->integer('room_id');
            $table->integer('promotion_id');
            $table->date('check_in')->nullable();
            $table->date('check_out');
            $table->double('total_price');
            $table->enum('status', ['confirmed','cancelled','pending']);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
