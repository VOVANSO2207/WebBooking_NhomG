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
        Schema::create('room_amenity_room', function (Blueprint $table) {
            $table->unsignedInteger('room_id'); // Khóa ngoại từ bảng rooms
            $table->unsignedInteger('amenity_id'); // Khóa ngoại từ bảng room_amenities
            
            // // Định nghĩa khóa ngoại
            // $table->foreign('room_id')->references('room_id')->on('rooms')->onDelete('cascade');
            // $table->foreign('amenity_id')->references('amenity_id')->on('room_amenities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_amenity_room');
    }
};
