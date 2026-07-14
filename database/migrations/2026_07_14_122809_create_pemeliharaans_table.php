<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeliharaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aset_id')->constrained('aset_bmn')->onDelete('cascade');
            $table->enum('jenis', ['rutin', 'situasional']);
            $table->foreignId('dilaporkan_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->text('deskripsi_kerusakan')->nullable();
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'proses', 'selesai'])->default('pending');
            $table->text('catatan_validasi')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nota_teknisi')->nullable();
            $table->dateTime('tanggal_pengajuan')->useCurrent();
            $table->dateTime('tanggal_selesai')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeliharaan');
    }
};
