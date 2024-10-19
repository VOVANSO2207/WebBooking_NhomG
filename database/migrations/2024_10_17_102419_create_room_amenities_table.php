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

        Schema::create('room_amenities', function (Blueprint $table) {
            $table->increments('amenity_id');
            $table->integer('room_id');
            $table->foreign('room_id')->references('room_id')->on('rooms');
            $table->string('amenity_name');
            $table->text('description');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_amenities');
    }
};
