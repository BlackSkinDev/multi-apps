<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'avatar',
        'bio',
        'enabled',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });

    }



    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Takes string password and Hashes it
     *
     */
    public function password() : Attribute
    {
        return Attribute::set(fn ($value) => Hash::make($value));
    }

    /**
     * get user firstname
     *
     */
    public function getFirstnameAttribute(): string
    {
        return (explode(" ",$this->name))[0];
    }

    /**
     * get user photo
     *
     */
    public function getPhotoAttribute(): string
    {
        $defaultLogoPath = url('/images/avatar.png');
        $logoFolder = 'public/user-images';

        if ($this->avatar && Storage::exists($logoFolder . '/' . $this->avatar)) {
            return url(Storage::url($logoFolder . '/' . $this->avatar));
        } else {
            return $defaultLogoPath;
        }
    }

    /**
     * get user initials
     *
     */
    public function getInitialsAttribute(): string
    {
        $nameArray = explode(' ',$this->name);
        $initials = "";

        if ($nameArray[0] !=='' && $nameArray[1] !== ''){
            $initials = substr($nameArray[0], 0, 1) . substr($nameArray[1], 0, 1);
            return strtoupper($initials);
        }
        return $initials;
    }

    public function scopeEnabled($query){
        return $query->where('enabled',true);
    }



}
