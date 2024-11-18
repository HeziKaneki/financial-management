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
        Schema::table('funds', function (Blueprint $table) {
            $table->decimal('balance', 20, 0)->change();  // Thay đổi kiểu dữ liệu cột balance thành DECIMAL(20, 0)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('funds', function (Blueprint $table) {
            $table->integer('balance')->change();  // Hoàn tác lại kiểu dữ liệu ban đầu (nếu cần)
        });
    }
};
