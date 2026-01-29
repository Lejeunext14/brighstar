<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'subject',
        'due_date',
        'status',
        'priority',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    /**
     * Get the user that owns this assignment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if assignment is overdue
     */
    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() && $this->status !== 'completed';
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

