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
        Schema::table('room_amenities', function (Blueprint $table) {
            $table->fullText(['amenity_name', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('room_amenities', function (Blueprint $table) {
            $table->dropFullText(['amenity_name', 'description']);
        });
    }
};
