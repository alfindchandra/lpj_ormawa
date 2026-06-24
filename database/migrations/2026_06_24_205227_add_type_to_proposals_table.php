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
        Schema::table('proposals', function (Blueprint $table) {
            // DIUBAH: Menggunakan setelah 'nama_kegiatan' karena 'title' tidak ada di tabel Anda
            $table->enum('type', ['dana', 'non_dana'])->default('dana')->after('nama_kegiatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};