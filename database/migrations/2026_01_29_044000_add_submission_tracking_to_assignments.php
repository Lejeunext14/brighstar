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
    if (!Schema::hasColumn('assignments', 'submitted_at')) {
        Schema::table('assignments', function (Blueprint $table) {
            $table->timestamp('submitted_at')->nullable();
            // Add other columns here using the same check or inside this block
        });
    }
    }
};
