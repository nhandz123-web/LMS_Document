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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên nhóm hoặc tên loại
            $table->string('slug')->nullable(); // Đường dẫn thân thiện (ví dụ: giao-trinh)

            // CỘT QUAN TRỌNG NHẤT: parent_id
            // Nếu parent_id = NULL -> Nó là Nhóm lớn (Cha)
            // Nếu parent_id có số -> Nó là Loại con (Con), thuộc về nhóm đó
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
