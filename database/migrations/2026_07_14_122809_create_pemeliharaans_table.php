<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeliharaan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('aset_id');
            $table->foreign('aset_id')->references('id')->on('aset_bmn')->onDelete('cascade');
            $table->enum('jenis', ['rutin', 'situasional']);
            $table->string('lokasi', 70)->nullable();
            $table->unsignedInteger('dilaporkan_oleh')->nullable();
            $table->foreign('dilaporkan_oleh')->references('id')->on('users')->nullOnDelete();
            $table->text('deskripsi_kerusakan')->nullable();
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'proses', 'selesai'])->default('pending');
            $table->string('catatan_validasi', 100)->nullable();
            $table->unsignedInteger('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
            $table->text('nota_teknisi')->nullable();
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
