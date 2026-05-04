<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->string('nama_kegiatan')->nullable()->after('user_id');
            $table->text('deskripsi')->nullable()->after('nama_kegiatan');
            $table->date('tanggal_mulai')->nullable()->after('deskripsi');
            $table->date('tanggal_selesai')->nullable()->after('tanggal_mulai');
        });
    }

    public function down()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn(['nama_kegiatan', 'deskripsi', 'tanggal_mulai', 'tanggal_selesai']);
        });
    }
};
