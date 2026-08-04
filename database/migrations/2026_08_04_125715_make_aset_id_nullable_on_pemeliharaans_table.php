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
            $table->dropForeign(['aset_id']);
        });

        Schema::table('pemeliharaan', function (Blueprint $table) {
            $table->unsignedBigInteger('aset_id')->nullable()->change();
            $table->foreign('aset_id')->references('id')->on('aset_bmn')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemeliharaan', function (Blueprint $table) {
            $table->dropForeign(['aset_id']);
        });

        Schema::table('pemeliharaan', function (Blueprint $table) {
            $table->unsignedBigInteger('aset_id')->nullable(false)->change();
            $table->foreign('aset_id')->references('id')->on('aset_bmn')->cascadeOnDelete();
        });
    }
};
