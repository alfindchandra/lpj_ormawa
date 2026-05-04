<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('kode_proposal')->unique();
            $table->string('nama_kegiatan');
            $table->text('deskripsi');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('tipe_lokasi', ['internal', 'eksternal'])->nullable();
            $table->string('tempat');
            $table->text('barang_diperlukan');
            $table->text('sewa_tempat');
            $table->text('jasa');
            $table->text('bahan');
            $table->decimal('anggaran', 15, 2);
            $table->string('file_proposal');
            $table->enum('status', ['pending', 'approved_bem', 'approved_admin', 'rejected'])->default('pending');
            $table->text('catatan_bem')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('proposals');
    }
};