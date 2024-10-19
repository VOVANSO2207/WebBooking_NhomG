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

        Schema::create('promotions', function (Blueprint $table) {
            $table->increments('promotion_id');
            $table->foreign('promotion_id')->references('room_id')->on('rooms');
            $table->string('promotion_code');
            $table->double('discount_amount');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
