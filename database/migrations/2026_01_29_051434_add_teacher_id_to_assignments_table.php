<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    if (!Schema::hasColumn('assignments', 'teacher_id')) {
        Schema::table('assignments', function (Blueprint $table) {
            $table->foreignId('teacher_id')->nullable()->constrained();
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropForeignIdFor('teacher_id');
        });
    }
};
