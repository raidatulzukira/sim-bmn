<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aset_bmn', function (Blueprint $table) {
            $table->id();
            $table->string('kode_aset')->unique();
            $table->string('nama_aset');
            $table->string('kategori');
            $table->text('spesifikasi')->nullable();
            $table->string('foto')->nullable();
            $table->foreignId('ruangan_id')->constrained('ruangan')->onDelete('restrict');
            $table->enum('status', ['tersedia', 'dipinjam', 'servis'])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aset_bmn');
    }
};
