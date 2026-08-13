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
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->string('batch_id', 50)->nullable()->after('id');
        });

        // Populate existing rows with unique UUID so they act as individual batches
        $peminjamans = \Illuminate\Support\Facades\DB::table('peminjaman')->get();
        foreach ($peminjamans as $peminjaman) {
            $nota = 'PMJ-' . date('Ymd') . '-' . str_pad($peminjaman->id, 4, '0', STR_PAD_LEFT);
            \Illuminate\Support\Facades\DB::table('peminjaman')
                ->where('id', $peminjaman->id)
                ->update(['batch_id' => $nota]);
        }
        
        // Optionally make it non-nullable if you want strict enforcement
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->string('batch_id', 50)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn('batch_id');
        });
    }
};
