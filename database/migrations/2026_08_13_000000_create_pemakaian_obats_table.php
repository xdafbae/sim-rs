<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemakaian_obats', function (Blueprint $table) {
            $table->id();
            $table->string('no_pemakaian', 30)->unique();
            $table->foreignId('jadwal_operasi_id')->constrained('jadwal_operasi')->restrictOnDelete();
            $table->string('no_rm', 50);
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
            $table->dateTime('tanggal_pemakaian');
            $table->json('items');
            $table->decimal('total_biaya', 15, 2)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['jadwal_operasi_id', 'tanggal_pemakaian']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemakaian_obats');
    }
};
