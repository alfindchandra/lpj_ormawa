<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->json('internal_items')->nullable()->after('bahan');
            $table->json('external_items')->nullable()->after('internal_items');
            $table->json('barang_items')->nullable()->after('external_items');
        });
    }

    public function down()
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn(['internal_items', 'external_items', 'barang_items']);
        });
    }
};
