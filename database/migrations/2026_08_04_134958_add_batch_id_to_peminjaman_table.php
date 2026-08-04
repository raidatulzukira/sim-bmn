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
            $table->uuid('batch_id')->nullable()->after('id');
        });

        // Populate existing rows with unique UUID so they act as individual batches
        $peminjamans = \Illuminate\Support\Facades\DB::table('peminjaman')->get();
        foreach ($peminjamans as $peminjaman) {
            \Illuminate\Support\Facades\DB::table('peminjaman')
                ->where('id', $peminjaman->id)
                ->update(['batch_id' => (string) \Illuminate\Support\Str::uuid()]);
        }
        
        // Optionally make it non-nullable if you want strict enforcement
        // Schema::table('peminjaman', function (Blueprint $table) {
        //     $table->uuid('batch_id')->nullable(false)->change();
        // });
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
