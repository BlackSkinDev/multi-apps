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


    protected $casts = [
        'expired_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->expired_at = Carbon::now()->addMinutes(2);
            $model->token      = hash('sha256', Str::random(40));
        });

    }


    public function clear(){
        $user = PersonalAccessToken::where('id',$this->personal_access_token_id)->first()->user;
        $user->tokens()->delete();
        $this->delete();
    }

}
