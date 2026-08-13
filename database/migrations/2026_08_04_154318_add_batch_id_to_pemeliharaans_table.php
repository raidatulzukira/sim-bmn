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
        Schema::table('pemeliharaan', function (Blueprint $table) {
            $table->string('batch_id', 50)->nullable()->after('id');
        });

        // Set unique UUID for existing records
        $pemeliharaans = \Illuminate\Support\Facades\DB::table('pemeliharaan')->get();
        foreach ($pemeliharaans as $p) {
            $nota = 'MTC-' . date('Ymd') . '-' . str_pad($p->id, 4, '0', STR_PAD_LEFT);
            \Illuminate\Support\Facades\DB::table('pemeliharaan')
                ->where('id', $p->id)
                ->update(['batch_id' => $nota]);
        }

        Schema::table('pemeliharaan', function (Blueprint $table) {
            $table->string('batch_id', 50)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemeliharaan', function (Blueprint $table) {
            $table->dropColumn('batch_id');
        });
    }
};
