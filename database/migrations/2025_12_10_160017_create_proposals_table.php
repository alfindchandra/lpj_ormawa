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
            
            // SUDAH BENAR: nullable() agar bisa dikosongkan (tidak diisi)
            $table->enum('tipe_lokasi', ['internal', 'eksternal'])->nullable();
            
            $table->string('tempat');
            
            // DIUBAH: Dibuat nullable() agar jika kosong tidak memicu database crash error
            $table->text('barang_diperlukan')->nullable();
            $table->text('sewa_tempat')->nullable();
            $table->text('jasa')->nullable();
            $table->text('bahan')->nullable();
            
            $table->decimal('anggaran', 15, 2)->default(0);
            $table->string('file_proposal'); // Untuk menyimpan path file pdf yang di-upload
            
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