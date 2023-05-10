<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class ProjectDevStage extends Model
{
    use HasFactory;

    protected $fillable = ['name','enabled'];
    CONST POSITION_GAP = 60000;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($item) {
             $item->position = self::query()->where('project_id',$item->project_id)
                    ->orderByDesc('position')->first()?->position + self::POSITION_GAP;
        });

    }

    public function scopeEnabled($query){
        return $query->where('enabled',true)->orderBy('position','asc');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

}
