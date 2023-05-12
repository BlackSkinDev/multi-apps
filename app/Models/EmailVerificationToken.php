<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class EmailVerificationToken extends Model
{
    use HasFactory;
    protected $fillable = ['user_id'];
    protected $casts = [
        'expired_at' => 'datetime',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->expired_at = Carbon::now()->addMinutes(config('app.email_verification_token_expiry'));
            $model->token      = generateHashToken(config('app.tokens_length'));
        });

    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
