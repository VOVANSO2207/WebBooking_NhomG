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

        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('room_id');
            $table->integer('hotel_id');
            $table->string('name');
            $table->double('price');
            $table->integer('discount_percent');
            $table->integer('capacity');
            $table->text('description');
            $table->unsignedInteger('room_type_id'); // Tạo cột khóa ngoại
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
