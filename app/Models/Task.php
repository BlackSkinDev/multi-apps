<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['title','description','project_id','project_dev_stage_id','user_id','reference'];

    public static function boot()
    {
        parent::boot();
        static::created(function ($item) {
            $lastTask = self::where('id', '<>', $item->id)->orderBy('id', 'desc')->first();
            $stage_id = ProjectDevStage::orderBy('priority')->first()->id;

            if ($lastTask) {
                $lastReference = $lastTask->reference;
                $lastReferenceParts = explode('-', $lastReference);
                $lastReferenceNumber = intval(array_pop($lastReferenceParts));
                $reference = strtoupper(substr($item->project->name,0,3))."-".$lastReferenceNumber + 1;
            } else {
                $reference = strtoupper(substr($item->project->name,0,3))."-"."1000";
            }
            $item->update(['reference' => $reference,'project_dev_stage_id'=>$stage_id]);
        });

    }

    public function projectDevStage(): BelongsTo
    {
        return $this->belongsTo(ProjectDevStage::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}

