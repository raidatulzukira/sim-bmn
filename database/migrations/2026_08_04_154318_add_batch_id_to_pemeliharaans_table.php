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
            $table->uuid('batch_id')->nullable()->after('id');
        });

        // Set unique UUID for existing records
        $pemeliharaans = \Illuminate\Support\Facades\DB::table('pemeliharaan')->get();
        foreach ($pemeliharaans as $p) {
            \Illuminate\Support\Facades\DB::table('pemeliharaan')
                ->where('id', $p->id)
                ->update(['batch_id' => (string) \Illuminate\Support\Str::uuid()]);
        }
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
