<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RefreshToken extends Model
{
    use HasFactory;

    protected $fillable = ['personal_access_token_id','expired_at','token'];

    CONST DEFAULT_EXPIRY        = 2;
    CONST REFRESH_TOKEN_LENGTH  = 40;


    protected $casts = [
        'expired_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->expired_at = Carbon::now()->addMinutes(self::DEFAULT_EXPIRY);
            $model->token      = hash('sha256', Str::random(self::REFRESH_TOKEN_LENGTH));
        });

    }


    public function clear(){
        $user = PersonalAccessToken::where('id',$this->personal_access_token_id)->first()->user;
        $user->tokens()->delete();
        $this->delete();
    }

}
