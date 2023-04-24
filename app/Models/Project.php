<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name','reference'];

    public static function boot()
    {
        parent::boot();
            static::created(function ($item) {
                $lastProject = self::where('id', '<>', $item->id)->orderBy('id', 'desc')->first();
                if ($lastProject) {
                    $lastReference = $lastProject->reference;
                    $lastReferenceParts = explode('-', $lastReference);
                    $lastReferenceNumber = intval(array_pop($lastReferenceParts));
                    $reference = strtoupper(substr($item->name,0,3))."-".$lastReferenceNumber + 1;
                } else {
                    $reference = strtoupper(substr($item->name,0,3))."-".mt_rand(1000,2000);
                }
                $item->update(['reference' => $reference]);
            });

    }

    /**
     * get all project tasks
     */
    protected function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->orderBy('created_at','desc');
    }


}
