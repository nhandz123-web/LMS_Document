<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('documents', function (Blueprint $t) {
            $t->string('original_name')->nullable();
            $t->string('drive_path')->nullable();   // hoặc drive_id tùy adapter
            $t->string('mime')->nullable();
            $t->unsignedBigInteger('size')->default(0);
        });
    }
    public function down(): void {
        Schema::table('documents', function (Blueprint $t) {
            $t->dropColumn(['original_name','drive_path','mime','size']);
        });
    }
};
