<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LessonProgress extends Model
{
    use HasFactory;

    protected $table = 'lesson_progress';

    protected $fillable = [
        'user_id',
        'lesson_slug',
        'subject',
        'lesson_name',
        'completed',
        'points',
        'streak',
        'questions_answered',
        'daily_points',
        'daily_streak',
        'last_reset_at',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'last_reset_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if daily progress needs to be reset (24 hours have passed)
     */
    public function shouldResetDailyProgress(): bool
    {
        if (!$this->last_reset_at) {
            return true; // First time, so reset
        }

        $lastReset = $this->last_reset_at;
        $now = Carbon::now();
        
        // Reset if more than 24 hours have passed
        return $now->diffInHours($lastReset) >= 24;
    }

    /**
     * Reset daily progress (called every 24 hours)
     */
    public function resetDailyProgress(): void
    {
        $this->update([
            'daily_points' => 0,
            'daily_streak' => 0,
            'last_reset_at' => Carbon::now(),
        ]);
    }

    /**
     * Reset daily progress if needed
     */
    public function checkAndResetDaily(): void
    {
        if ($this->shouldResetDailyProgress()) {
            $this->resetDailyProgress();
        }
    }

    /**
     * Add daily points (accumulates throughout the day)
     */
    public function addDailyPoints($points = 1): void
    {
        $this->checkAndResetDaily();
        // Reload the model to get latest data after potential reset
        $this->refresh();
        $this->increment('daily_points', $points);
    }

    /**
     * Get daily progress with automatic reset check
     */
    public function getDailyProgress(): array
    {
        $this->checkAndResetDaily();
        $this->refresh();

        return [
            'daily_points' => $this->daily_points,
            'daily_streak' => $this->daily_streak,
            'last_reset_at' => $this->last_reset_at,
        ];
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
