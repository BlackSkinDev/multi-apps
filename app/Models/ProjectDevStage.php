<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectDevStage extends Model
{
    use HasFactory;

    protected $fillable = ['name','enabled'];

    public function scopeEnabled($query){
        return $query->where('enabled',true)->orderBy('position','asc');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

}
