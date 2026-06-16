<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kabinets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')->constrained('periods')->onDelete('cascade');
            $table->enum('ormawa_type', ['bem', 'hmp', 'ukm'])->default('hmp');
            $table->string('ormawa_name'); // Nama ormawa/UKM (misal: HMPTI, UKM ALAM)
            $table->string('nama_kabinet')->nullable(); // Nama kabinet (misal: Kabinet Cakrawala)
            $table->string('nama_ketua');
            $table->string('nama_wakil')->nullable();
            $table->string('nama_bendahara')->nullable();
            $table->string('nama_sekretaris')->nullable();
            $table->date('tanggal_dilantik');
            $table->date('tanggal_selesai');
            $table->boolean('is_active')->default(false);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kabinets');
    }
};
