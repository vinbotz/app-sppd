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
        Schema::table('sppds', function (Blueprint $table) {
            $columnsToDrop = ['biaya_transportasi', 'biaya_penginapan', 'biaya_makan', 'biaya_lainnya'];
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('sppds', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sppds', function (Blueprint $table) {
            if (!Schema::hasColumn('sppds', 'biaya_transportasi')) {
                $table->integer('biaya_transportasi')->default(0);
            }
            if (!Schema::hasColumn('sppds', 'biaya_penginapan')) {
                $table->integer('biaya_penginapan')->default(0);
            }
            if (!Schema::hasColumn('sppds', 'biaya_makan')) {
                $table->integer('biaya_makan')->default(0);
            }
            if (!Schema::hasColumn('sppds', 'biaya_lainnya')) {
                $table->integer('biaya_lainnya')->default(0);
            }
        });
    }
};
