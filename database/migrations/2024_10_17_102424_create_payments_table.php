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

        Schema::create('payments', function (Blueprint $table) {
            $table->increments('payment_id');
            $table->integer('booking_id');
            $table->enum('payment_status', ['Completed', 'Pending', 'Failed']); 
            $table->enum('payment_method', ['momo', 'vnpay', 'Cod']); 
            $table->foreign('payment_status')->references('booking_id')->on('booking');
            $table->decimal('amount');
            $table->dateTime('payment_date');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
