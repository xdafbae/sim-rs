<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelayanan_laboratorium', function (Blueprint $table) {
            $table->id();
            $table->string('no_pelayanan', 30)->unique();
            $table->string('no_rm', 50);
            $table->string('nama_pasien');
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin', 20)->nullable();
            $table->string('status_perkawinan', 30)->nullable();
            $table->text('alamat')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('no_identitas', 32)->nullable();
            $table->string('no_telepon', 30)->nullable();
            $table->dateTime('tanggal_pelayanan');
            $table->boolean('cyto')->default(false);
            $table->string('cara_masuk')->nullable();
            $table->string('poliklinik_ruang')->nullable();
            $table->string('no_kamar_tt')->nullable();
            $table->string('kelas', 50)->nullable();
            $table->string('cara_bayar')->nullable();
            $table->string('dokter_dpjp')->nullable();
            $table->text('instruksi_dokter')->nullable();
            $table->string('dokter_pemeriksa')->nullable();
            $table->string('pelaksana_petugas')->nullable();
            $table->text('klinis_pasien')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['no_rm', 'tanggal_pelayanan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelayanan_laboratorium');
    }
};
