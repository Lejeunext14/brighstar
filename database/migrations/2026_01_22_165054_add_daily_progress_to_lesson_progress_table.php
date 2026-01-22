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
        Schema::table('lesson_progress', function (Blueprint $table) {
            $table->integer('daily_points')->default(0)->after('points');
            $table->integer('daily_streak')->default(0)->after('daily_points');
            $table->timestamp('last_reset_at')->nullable()->after('daily_streak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lesson_progress', function (Blueprint $table) {
            $table->dropColumn(['daily_points', 'daily_streak', 'last_reset_at']);
        });
    }
};
