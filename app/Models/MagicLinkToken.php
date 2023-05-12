<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MagicLinkToken extends Model
{
    use HasFactory;

    protected $fillable = ['email','expired_at','token'];


    protected $casts = [
        'expired_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->expired_at = Carbon::now()->addMinutes(config('app.magic_link_token_expiry'));
            $model->token      = hash('sha256', Str::random(config('app.tokens_length')));
        });

    }
}
