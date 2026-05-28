<?php

namespace App\Models;

use Database\Factories\AssessmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Assessment extends Model
{
    /** @use HasFactory<AssessmentFactory> */
    use HasFactory;

    protected $fillable = [
        'child_id',
        'therapis_id',
        'answers',
        'score',
        'result_classification',
    ];

    protected $casts = [
        'answers' => 'array',
        'score' => 'integer',
    ];

    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class);
    }

    public function therapis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'therapis_id');
    }

    public function task(): HasOne
    {
        return $this->hasOne(Task::class);
    }
}
