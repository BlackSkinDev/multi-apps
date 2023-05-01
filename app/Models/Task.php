<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['title','description','project_id','project_dev_stage_id','user_id','reference','position'];
    const POSITION_GAP = 60000;
    const POSITION_MIN = 0.0002;
    const DEFAULT_TASK_REFERENCE = 1000;

    public static function boot()
    {
        parent::boot();
        static::created(function ($item) {
            $lastTaskReference = self::where('id', '<>', $item->id)->orderBy('id', 'desc')->first()?->reference;
            $stage_id = ProjectDevStage::orderBy('position')->first()->id;

            if ($lastTaskReference) {
                $lastReferenceParts = explode('-', $lastTaskReference);
                $lastReferenceNumber = intval(array_pop($lastReferenceParts));
                $reference = strtoupper(substr($item->project->name,0,3))."-".$lastReferenceNumber + 1;
            } else {
                $reference = strtoupper(substr($item->project->name,0,3))."-".self::DEFAULT_TASK_REFERENCE;
            }
            $item->update([
                'reference' => $reference,
                'project_dev_stage_id'=>$stage_id,
                'position'=>self::query()->where('project_id',$item->project_id)
                    ->orderByDesc('position')->first()?->position + self::POSITION_GAP
            ]);
        });
        static::saved(function ($model) {
            if ($model->position < self::POSITION_MIN){
                DB::statement("SET @previousPosition :=0");
                DB::statement("
                UPDATE tasks
                SET position = (@previousPosition := @previousPosition + ?)
                WHERE project_dev_stage_id = ?
                ORDER BY position
                ",[
                        self::POSITION_GAP,
                        $model->project_dev_stage_id
                    ]);
                }
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

