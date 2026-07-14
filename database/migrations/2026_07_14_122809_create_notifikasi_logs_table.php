<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasi_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('referensi_tipe')->nullable();
            $table->unsignedBigInteger('referensi_id')->nullable();
            $table->text('pesan');
            $table->enum('status_kirim', ['terkirim', 'gagal']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi_log');
    }
};
