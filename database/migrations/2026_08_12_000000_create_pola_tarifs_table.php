<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pola_tarifs', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_pelayanan');
            $table->string('kode_pelayanan')->unique();
            $table->string('instalasi');
            $table->string('sub_instalasi')->nullable();
            $table->string('kategori');
            $table->boolean('eklaim')->default(false);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pola_tarifs');
    }
};
