<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_operasi', function (Blueprint $table) {
            $table->id();
            $table->string('no_rm', 50)->index();
            $table->string('nama_pasien');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin', 20);
            $table->string('status_perkawinan', 30);
            $table->text('alamat');
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->string('pekerjaan');
            $table->string('no_ktp', 32);
            $table->string('no_telepon', 30);
            $table->dateTime('tanggal_rencana_operasi');
            $table->string('pemberi_instruksi');
            $table->string('tipe_pelayanan', 20);
            $table->string('jenis_pelayanan');
            $table->text('keterangan_deskripsi')->nullable();
            $table->string('no_slip', 100)->nullable();
            $table->dateTime('tanggal_jadwal_operasi')->index();
            $table->dateTime('tanggal_operasi_tindakan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_operasi');
    }
};
