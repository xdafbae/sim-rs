<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjualan_obats', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi', 30)->unique();
            $table->string('no_rm', 30);
            $table->string('no_copy_resep', 50)->nullable();
            $table->string('nama_pasien', 150);
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin', 20)->nullable();
            $table->string('status_pasien', 50)->nullable();
            $table->text('alamat')->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kabupaten', 100)->nullable();
            $table->string('pekerjaan', 100)->nullable();
            $table->string('no_ktp', 30)->nullable();
            $table->string('telepon', 30)->nullable();
            $table->decimal('akomodasi', 15, 2)->default(0);
            $table->unsignedInteger('berat_badan')->nullable();
            $table->dateTime('tanggal');
            $table->string('nama_dokter', 150)->nullable();
            $table->boolean('jasa_farmasi')->default(false);
            $table->json('items');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualan_obats');
    }
};
