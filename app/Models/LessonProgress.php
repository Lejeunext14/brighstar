<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonProgress extends Model
{
    use HasFactory;

    protected $table = 'lesson_progress';

    protected $fillable = [
        'user_id',
        'lesson_slug',
        'completed',
        'points',
        'streak',
        'questions_answered',
    ];

    protected $casts = [
        'completed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function markLessonComplete($userId, $lessonSlug)
    {
        return self::updateOrCreate(
            ['user_id' => $userId, 'lesson_slug' => $lessonSlug],
            ['completed' => true]
        );
    }

    public static function isLessonCompleted($userId, $lessonSlug)
    {
        return self::where('user_id', $userId)
            ->where('lesson_slug', $lessonSlug)
            ->where('completed', true)
            ->exists();
    }
}
