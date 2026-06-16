<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Tambahkan role hmp dan ukm ke tabel users.
     * SQLite tidak support ALTER COLUMN untuk enum,
     * jadi kita recreate kolom dengan string dan validasi di level aplikasi.
     */
    public function up(): void
    {
        // Untuk SQLite: tambah kolom baru dengan nama sementara
        Schema::table('users', function (Blueprint $table) {
            $table->string('role_new')->default('ormawa')->after('role');
        });

        // Copy data lama ke kolom baru
        DB::table('users')->update(['role_new' => DB::raw('role')]);

        // Drop kolom lama
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        // Rename kolom baru
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('role_new', 'role');
        });
    }

    public function down(): void
    {
        // Reversi: kembalikan ke enum lama (hanya admin, bem, ormawa)
        Schema::table('users', function (Blueprint $table) {
            $table->string('role_old')->default('ormawa')->after('role');
        });

        DB::table('users')->whereIn('role', ['hmp', 'ukm'])->update(['role_old' => 'ormawa']);
        DB::table('users')->whereNotIn('role', ['hmp', 'ukm'])->update(['role_old' => DB::raw('role')]);

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('role_old', 'role');
        });
    }
};
