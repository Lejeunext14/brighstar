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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'section')) {
                $table->enum('section', ['kinder_1', 'kinder_2'])->nullable()->after('role');
            }
            if (!Schema::hasColumn('users', 'class_name')) {
                $table->string('class_name')->nullable()->after('section');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['section', 'class_name']);
        });
    }
};
