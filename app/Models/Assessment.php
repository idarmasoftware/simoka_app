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

    /**
     * Get the breakdown of scores per sensory domain.
     *
     * @return array<string, array{name: string, score: int, max_score: int, percentage: int, classification: string}>
     */
    public function getDomainBreakdownAttribute(): array
    {
        $answers = $this->answers ?? [];

        $domains = [
            'Tactile Sensitivity' => [
                'name' => 'Sensitivitas Taktil (Tactile Sensitivity)',
                'questions' => [1, 2, 3, 4, 5, 6, 7],
                'max_score' => 35,
                'ranges' => [
                    'typical' => [30, 35],
                    'probable' => [27, 29],
                    'definite' => [7, 26],
                ],
            ],
            'Taste/Smell Sensitivity' => [
                'name' => 'Sensitivitas Rasa/Bau (Taste/Smell Sensitivity)',
                'questions' => [8, 9, 10, 11],
                'max_score' => 20,
                'ranges' => [
                    'typical' => [15, 20],
                    'probable' => [12, 14],
                    'definite' => [4, 11],
                ],
            ],
            'Movement Sensitivity' => [
                'name' => 'Sensitivitas Gerakan (Movement Sensitivity)',
                'questions' => [12, 13, 14],
                'max_score' => 15,
                'ranges' => [
                    'typical' => [13, 15],
                    'probable' => [11, 12],
                    'definite' => [3, 10],
                ],
            ],
            'Underresponsive/Seeks Sensation' => [
                'name' => 'Underresponsive/Mencari Sensasi',
                'questions' => [15, 16, 17, 18, 19, 20, 21],
                'max_score' => 35,
                'ranges' => [
                    'typical' => [27, 35],
                    'probable' => [24, 26],
                    'definite' => [7, 23],
                ],
            ],
            'Auditory Filtering' => [
                'name' => 'Penyaringan Suara (Auditory Filtering)',
                'questions' => [22, 23, 24, 25, 26, 27],
                'max_score' => 30,
                'ranges' => [
                    'typical' => [23, 30],
                    'probable' => [20, 22],
                    'definite' => [6, 19],
                ],
            ],
            'Low Energy/Weak' => [
                'name' => 'Lemah/Kurang Berenergi (Low Energy/Weak)',
                'questions' => [28, 29, 30, 31, 32, 33],
                'max_score' => 30,
                'ranges' => [
                    'typical' => [26, 30],
                    'probable' => [24, 25],
                    'definite' => [6, 23],
                ],
            ],
            'Visual/Auditory Sensitivity' => [
                'name' => 'Sensitivitas Auditori/Visual (Visual/Auditory Sensitivity)',
                'questions' => [34, 35, 36, 37, 38],
                'max_score' => 25,
                'ranges' => [
                    'typical' => [19, 25],
                    'probable' => [16, 18],
                    'definite' => [5, 15],
                ],
            ],
        ];

        $result = [];
        foreach ($domains as $key => $info) {
            $score = 0;
            foreach ($info['questions'] as $qId) {
                $score += (int) ($answers[$qId] ?? 0);
            }

            $max = $info['max_score'];
            $percentage = $max > 0 ? round(($score / $max) * 100) : 0;

            $classification = 'Definite Difference';
            if ($score >= $info['ranges']['typical'][0] && $score <= $info['ranges']['typical'][1]) {
                $classification = 'Typical Performance';
            } elseif ($score >= $info['ranges']['probable'][0] && $score <= $info['ranges']['probable'][1]) {
                $classification = 'Probable Difference';
            }

            $result[$key] = [
                'name' => $info['name'],
                'score' => $score,
                'max_score' => $max,
                'percentage' => $percentage,
                'classification' => $classification,
            ];
        }

        return $result;
    }
}
