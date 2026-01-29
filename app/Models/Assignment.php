<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'user_id',
        'teacher_id',
        'title',
        'description',
        'subject',
        'due_date',
        'status',
        'priority',
        'submitted_at',
        'submission_notes',
        'is_archived',
        'archived_at',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'submitted_at' => 'datetime',
        'archived_at' => 'datetime',
    ];

    /**
     * Get the student that owns this assignment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the teacher who created this assignment
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Check if assignment is overdue
     */
    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() && $this->status !== 'completed';
    }

    /**
     * Check if assignment is submitted
     */
    public function isSubmitted(): bool
    {
        return $this->submitted_at !== null;
    }

    /**
     * Get priority label
     */
    public function getPriorityLabel(): string
    {
        return match($this->priority) {
            0 => 'Low',
            1 => 'Medium',
            2 => 'High',
            default => 'Low'
        };
    }

    /**
     * Get priority color
     */
    public function getPriorityColor(): string
    {
        return match($this->priority) {
            0 => 'gray',
            1 => 'yellow',
            2 => 'red',
            default => 'gray'
        };
    }
}

