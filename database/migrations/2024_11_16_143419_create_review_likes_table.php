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
        Schema::create('review_likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('review_id');  // Liên kết với bảng reviews
            $table->unsignedBigInteger('user_id');  // Liên kết với bảng users
            $table->timestamps();
    
            // Chỉ cho phép mỗi người dùng thích mỗi bình luận một lần
            $table->unique(['review_id', 'user_id']);  
    
            // Thêm khóa ngoại
            $table->foreign('review_id')->references('review_id')->on('reviews')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('review_likes');
    }
    
};
