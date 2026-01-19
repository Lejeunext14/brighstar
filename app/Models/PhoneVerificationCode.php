<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneVerificationCode extends Model
{
    use HasFactory;

    protected $table = 'phone_verification_codes';

    protected $fillable = [
        'user_id',
        'code',
        'type',
        'target_phone',
        'child_user_id',
        'verified',
        'expires_at',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * Generate a random 6-digit code
     */
    public static function generateCode(): string
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Check if code is still valid
     */
    public function isValid(): bool
    {
        return !$this->verified && now()->lessThan($this->expires_at);
    }

    /**
     * Relationship to user (parent)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship to child user
     */
    public function child()
    {
        return $this->belongsTo(User::class, 'child_user_id');
    }
}
