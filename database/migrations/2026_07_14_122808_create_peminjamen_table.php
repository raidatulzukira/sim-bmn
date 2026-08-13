<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('aset_id');
            $table->foreign('aset_id')->references('id')->on('aset_bmn')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('keperluan', 150);
            $table->dateTime('estimasi_waktu_pinjam');
            $table->dateTime('tanggal_pinjam')->nullable();
            $table->dateTime('tanggal_kembali_rencana');
            $table->dateTime('tanggal_kembali_aktual')->nullable();
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'dipinjam', 'dikembalikan'])->default('pending');
            $table->text('catatan_penolakan')->nullable();
            $table->string('foto_serah_terima', 255)->nullable();
            $table->unsignedInteger('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
