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
            if (!Schema::hasColumn('sppds', 'catatan')) {
                $table->text('catatan')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sppds', function (Blueprint $table) {
            if (Schema::hasColumn('sppds', 'catatan')) {
                $table->dropColumn(['catatan']);
            }
        });
    }
};
