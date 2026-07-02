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
            $table->string('dana_sponsor_keterangan')->nullable()->after('kebersihan_biaya');
            $table->decimal('dana_sponsor_biaya', 12, 2)->default(0)->after('dana_sponsor_keterangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn(['dana_sponsor_keterangan', 'dana_sponsor_biaya']);
        });
    }
};
