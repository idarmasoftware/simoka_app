<?php

namespace App\Models;

use Database\Factories\TaskStepFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskStep extends Model
{
    /** @use HasFactory<TaskStepFactory> */
    use HasFactory;

    protected $fillable = [
        'task_id',
        'step_number',
        'instruction',
        'video_path',
        'notes',
        'feedback',
        'status',
    ];

    protected $casts = [
        'step_number' => 'integer',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
