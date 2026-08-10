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
        // First convert existing data
        $pemeliharaans = \Illuminate\Support\Facades\DB::table('pemeliharaan')->whereNotNull('nota_teknisi')->get();
        foreach ($pemeliharaans as $p) {
            // Check if it's already a JSON array
            $decoded = json_decode($p->nota_teknisi, true);
            if (!is_array($decoded)) {
                // If it's a plain string, wrap it in JSON array
                \Illuminate\Support\Facades\DB::table('pemeliharaan')
                    ->where('id', $p->id)
                    ->update(['nota_teknisi' => json_encode([$p->nota_teknisi])]);
            }
        }

        Schema::table('pemeliharaan', function (Blueprint $table) {
            $table->text('nota_teknisi')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemeliharaan', function (Blueprint $table) {
            $table->string('nota_teknisi', 255)->nullable()->change();
        });
    }
};
