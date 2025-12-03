<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // 1. Dọn dẹp dữ liệu cũ để tránh lỗi (Data Truncated)
        // Chuyển hết 'user' cũ thành 'SV', 'admin' cũ thành 'ADMIN'
        DB::table('users')->where('role', 'user')->update(['role' => 'SV']);
        DB::table('users')->where('role', 'admin')->update(['role' => 'ADMIN']);

        // 2. Sửa cột role thành ENUM mới (ADMIN, GV, SV)
        // Lưu ý: Dùng câu lệnh SQL thuần để thay đổi ENUM an toàn nhất trên MySQL
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('ADMIN', 'GV', 'SV') NOT NULL DEFAULT 'SV'");
    }

    public function down()
    {
        // Quay lại trạng thái cũ (nếu cần rollback)
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'user') NOT NULL DEFAULT 'user'");
    }
};