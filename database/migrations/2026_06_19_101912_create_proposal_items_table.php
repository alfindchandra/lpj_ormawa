<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposal_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained()->cascadeOnDelete();

            // Tipe item: 'internal', 'external', 'barang'
            $table->enum('tipe', ['internal', 'external', 'barang']);

            // Nama barang/jasa (untuk internal & barang)
            $table->string('nama')->nullable();

            // Nama jasa (untuk external)
            $table->string('jasa')->nullable();

            $table->unsignedInteger('jumlah')->default(1);
            $table->decimal('harga', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2)->default(0);

            // Urutan tampil
            $table->unsignedSmallInteger('urutan')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposal_items');
    }
};