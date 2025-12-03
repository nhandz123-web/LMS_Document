<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            // Thêm cột privacy
            // 'public': Ai cũng xem được
            // 'restricted': Chỉ GV và Admin xem được
            $table->enum('privacy', ['public', 'restricted'])
                  ->default('public') // Mặc định là công khai
                  ->after('status');  // Đặt sau cột status cho dễ nhìn
        });
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('privacy');
        });
    }
};