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

        Schema::create('order_histories', function (Blueprint $table) {
            $table->increments('history_id');
            $table->foreign('history_id')->references('booking_id')->on('booking');
            $table->integer('user_id');
            $table->integer('booking_id')->unsigned(); 
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_history');
    }
};
