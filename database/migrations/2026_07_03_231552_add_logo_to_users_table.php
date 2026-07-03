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
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom logo berbentuk string, boleh kosong (nullable)
            // Diletakkan setelah kolom 'phone' (sesuaikan urutan di database Anda)
            $table->string('logo')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom logo jika migrasi di-rollback
            $table->dropColumn('logo');
        });
    }
};