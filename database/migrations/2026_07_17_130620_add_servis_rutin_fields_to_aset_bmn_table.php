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
            $table->integer('interval_servis_tahun')->nullable()->after('status')->comment('Interval servis rutin dalam satuan tahun (misal: 1 atau 5)');
            $table->date('tanggal_servis_terakhir')->nullable()->after('interval_servis_tahun')->comment('Tanggal terakhir aset diservis secara rutin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aset_bmn', function (Blueprint $table) {
            $table->dropColumn(['interval_servis_tahun', 'tanggal_servis_terakhir']);
        });
    }
};
