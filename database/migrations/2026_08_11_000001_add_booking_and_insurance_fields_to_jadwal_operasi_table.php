<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_operasi', function (Blueprint $table) {
            $table->string('no_booking', 30)->nullable()->unique()->after('id');
            $table->string('golongan_darah', 3)->nullable()->after('jenis_kelamin');
            $table->string('no_bpjs', 30)->nullable()->after('no_ktp');
        });

        DB::table('jadwal_operasi')
            ->select('id')
            ->orderBy('id')
            ->eachById(function ($jadwal): void {
                DB::table('jadwal_operasi')
                    ->where('id', $jadwal->id)
                    ->update([
                        'no_booking' => 'BOOK-'.str_pad((string) $jadwal->id, 6, '0', STR_PAD_LEFT),
                    ]);
            });
    }

    public function down(): void
    {
        Schema::table('jadwal_operasi', function (Blueprint $table) {
            $table->dropUnique(['no_booking']);
            $table->dropColumn(['no_booking', 'golongan_darah', 'no_bpjs']);
        });
    }
};
