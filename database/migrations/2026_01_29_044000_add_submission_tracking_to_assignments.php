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
        /**
         * ========================================
         * Students and Teachers Section
         * ========================================
         */

        // Add Students and Teachers with class level selection and section/class belongings
        $this->addStudentsAndTeachersWithClassLevel();
        $this->addStudentAndTeacherSectionBelongings();
    }

    /**
     * Add Students and Teachers Section with Dropdown Selection for Kinder 1 or Kinder 2
     */
    private function addStudentsAndTeachersWithClassLevel(): void
    {
        if (!Schema::hasColumn('assignments', 'student_id')) {
            Schema::table('assignments', function (Blueprint $table) {
                // Student columns
                $table->unsignedBigInteger('student_id')->nullable();
                $table->enum('student_class_level', ['kinder_1', 'kinder_2'])->nullable();
                
                // Teacher columns
                $table->unsignedBigInteger('teacher_id')->nullable();
                $table->enum('teacher_class_level', ['kinder_1', 'kinder_2'])->nullable();
                
                // Submission tracking
                $table->timestamp('submitted_at')->nullable();
                
                // Foreign key constraints
                $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    /**
     * Add Student and Teacher Section Belongings to Users Table
     * Tracks which section/class students and teachers belong to
     */
    private function addStudentAndTeacherSectionBelongings(): void
    {
        if (!Schema::hasColumn('users', 'section')) {
            Schema::table('users', function (Blueprint $table) {
                // Section field for tracking student/teacher class assignment
                $table->enum('section', ['kinder_1', 'kinder_2'])->nullable()->after('role');
                $table->string('class_name')->nullable()->after('section');
            });
        }
    }
};
