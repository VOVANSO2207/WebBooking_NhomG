<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFulltextIndexToPosts extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Thêm chỉ mục FULLTEXT cho các cột title và description
            $table->fullText(['title', 'description']);
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Xóa chỉ mục FULLTEXT nếu rollback
            $table->dropFullText(['title', 'description']);
        });
    }
}
