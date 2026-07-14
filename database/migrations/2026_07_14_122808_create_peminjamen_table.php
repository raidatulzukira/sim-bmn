<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aset_id')->constrained('aset_bmn')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('keperluan');
            $table->dateTime('estimasi_waktu_pinjam');
            $table->dateTime('tanggal_pinjam')->nullable();
            $table->dateTime('tanggal_kembali_rencana')->nullable();
            $table->dateTime('tanggal_kembali_aktual')->nullable();
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'dipinjam', 'dikembalikan'])->default('pending');
            $table->text('catatan_penolakan')->nullable();
            $table->string('foto_serah_terima')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
