<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->text('pro_description')->nullable()->after('discount_amount');
        });
    }
    
    public function down()
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->dropColumn('pro_description');
        });
    }
};
