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
        Schema::table('kabinets', function (Blueprint $table) {
            // Mengubah enum dengan menambahkan 'ormawa' dan mengganti default-nya
            $table->enum('ormawa_type', ['bem', 'hmp', 'ukm', 'ormawa'])
                  ->default('ormawa')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kabinets', function (Blueprint $table) {
            // Mengembalikan ke struktur semula jika migrasi di-rollback
            $table->enum('ormawa_type', ['bem', 'hmp', 'ukm'])
                  ->default('hmp')
                  ->change();
        });
    }
};