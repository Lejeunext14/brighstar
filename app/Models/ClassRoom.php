<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    protected $table = 'classrooms';

    protected $fillable = [
        'teacher_id',
        'name',
        'description',
        'grade_level',
        'subject',
        'schedule',
        'room_number',
    ];

    /**
     * Get the teacher that owns this classroom
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the students in this classroom
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'classroom_student', 'classroom_id', 'student_id');
    }

    /**
     * Get student count
     */
    public function getStudentCountAttribute()
    {
        return $this->students()->count();
    }

    /**
     * Calculate class progress percentage
     */
    public function getProgressPercentageAttribute()
    {
        $students = $this->students()->get();
        
        if ($students->isEmpty()) {
            return 0;
        }

        $totalProgress = 0;
        foreach ($students as $student) {
            $completedLessons = LessonProgress::where('user_id', $student->id)
                ->where('completed', true)
                ->count();
            $totalLessons = LessonProgress::where('user_id', $student->id)->count();
            
            if ($totalLessons > 0) {
                $totalProgress += ($completedLessons / $totalLessons) * 100;
            }
        }

        return round($totalProgress / $students->count());
    }
}
