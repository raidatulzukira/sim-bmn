<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('aset_bmn', function (Blueprint $table) {
            // Hapus kolom lama yang tidak terpakai
            $table->dropColumn(['kategori', 'spesifikasi']);

            // Ganti nama kolom lama agar sesuai format (jika DB driver support rename, tapi mari kita pastikan dengan renameColumn)
            $table->renameColumn('kode_aset', 'kode_barang');
            $table->renameColumn('nama_aset', 'nama_barang');
        });

        // Terkadang SQLite tidak support rename+add di satu schema block yang sama, jadi kita pisahkan block baru.
        Schema::table('aset_bmn', function (Blueprint $table) {
            // Tambah kolom baru
            $table->string('jenis_bmn')->nullable()->after('id');
            $table->string('nup')->nullable()->after('kode_barang');
            $table->string('merk')->nullable()->after('nama_barang');
            $table->string('tipe')->nullable()->after('merk');
            $table->string('nama')->nullable()->after('tipe');
            $table->date('tanggal_perolehan')->nullable()->after('nama');
            $table->decimal('nilai_perolehan_pertama', 20, 2)->nullable()->after('tanggal_perolehan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aset_bmn', function (Blueprint $table) {
            // Rollback penambahan
            $table->dropColumn([
                'jenis_bmn', 'nup', 'merk', 'tipe', 'nama', 'tanggal_perolehan', 'nilai_perolehan_pertama'
            ]);
        });

        Schema::table('aset_bmn', function (Blueprint $table) {
            // Rollback rename
            $table->renameColumn('kode_barang', 'kode_aset');
            $table->renameColumn('nama_barang', 'nama_aset');

            // Rollback penghapusan
            $table->string('kategori');
            $table->text('spesifikasi')->nullable();
        });
    }
};
