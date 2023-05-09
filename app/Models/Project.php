<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name','reference'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($item) {
            $reference = strtoupper(substr($item->name,0,3));
            $item->reference =  $reference;
        });

    }

    /**
     * get all project tasks
     */
    protected function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->orderBy('created_at','desc');
    }

    /**
     * get project company
     */
    protected function company(): BelongsTo
    {
        return $this->BelongsTo(Company::class);
    }


}
