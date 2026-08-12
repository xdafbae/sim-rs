<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30)->unique();
            $table->string('jenis', 100);
            $table->string('nama_obat_alkes', 150);
            $table->string('kode_obat', 50)->nullable();
            $table->string('nama_obat', 150)->nullable();
            $table->string('detail_kelas_terapi', 150)->nullable();
            $table->decimal('hna_ppn', 15, 2)->default(0);
            $table->decimal('hpp', 15, 2)->default(0);
            $table->decimal('margin', 8, 2)->default(0);
            $table->unsignedInteger('persediaan_rs')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};
