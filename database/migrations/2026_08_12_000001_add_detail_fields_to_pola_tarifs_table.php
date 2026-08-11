<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pola_tarifs', function (Blueprint $table) {
            $table->boolean('pelayanan_pendapatan_lain')->default(false)->after('aktif');
            $table->date('tanggal_update_terakhir')->nullable()->after('pelayanan_pendapatan_lain');
            $table->decimal('score', 8, 2)->default(1)->after('tanggal_update_terakhir');
            $table->string('kategori_variabel_eklaim')->nullable()->after('score');
        });
    }

    public function down(): void
    {
        Schema::table('pola_tarifs', function (Blueprint $table) {
            $table->dropColumn(['pelayanan_pendapatan_lain', 'tanggal_update_terakhir', 'score', 'kategori_variabel_eklaim']);
        });
    }
};
