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
            // Add parent_id column for parent-child relationship
            $table->unsignedBigInteger('parent_id')->nullable()->after('id');
            
            // Add relationship_type to distinguish between 'parent' and 'student'
            $table->string('relationship_type')->default('student')->after('parent_id');
            
            // Foreign key constraint
            $table->foreign('parent_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['parent_id', 'relationship_type']);
        });
    }
};
