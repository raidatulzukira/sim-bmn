<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE aset_bmn MODIFY COLUMN status ENUM('tersedia', 'dipinjam', 'servis', 'menunggu_persetujuan', 'menunggu_serah_terima', 'menunggu_servis') DEFAULT 'tersedia'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Downgrading enum is tricky if there are active rows with new statuses, but for safety:
        DB::statement("ALTER TABLE aset_bmn MODIFY COLUMN status ENUM('tersedia', 'dipinjam', 'servis') DEFAULT 'tersedia'");
    }
};
