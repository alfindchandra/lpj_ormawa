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
        $table->string('kebersihan_keterangan')->nullable()->after('file_proposal');
        $table->decimal('kebersihan_biaya', 12, 2)->default(0)->after('kebersihan_keterangan');
    });
}

public function down(): void
{
    Schema::table('proposals', function (Blueprint $table) {
        $table->dropColumn(['kebersihan_keterangan', 'kebersihan_biaya']);
    });
}
};
