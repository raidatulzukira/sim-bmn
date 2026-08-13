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
            $table->tinyInteger('interval_servis_bulan')->nullable()->after('interval_servis_tahun')->comment('Interval servis rutin dalam satuan bulan (misal: 6 atau 12)');
        });

        \Illuminate\Support\Facades\DB::table('aset_bmn')->whereNotNull('interval_servis_tahun')->update([
            'interval_servis_bulan' => \Illuminate\Support\Facades\DB::raw('interval_servis_tahun * 12')
        ]);

        Schema::table('aset_bmn', function (Blueprint $table) {
            $table->dropColumn('interval_servis_tahun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aset_bmn', function (Blueprint $table) {
            $table->integer('interval_servis_tahun')->nullable()->after('status')->comment('Interval servis rutin dalam satuan tahun (misal: 1 atau 5)');
        });

        \Illuminate\Support\Facades\DB::table('aset_bmn')->whereNotNull('interval_servis_bulan')->update([
            'interval_servis_tahun' => \Illuminate\Support\Facades\DB::raw('interval_servis_bulan / 12')
        ]);

        Schema::table('aset_bmn', function (Blueprint $table) {
            $table->dropColumn('interval_servis_bulan');
        });
    }
};
