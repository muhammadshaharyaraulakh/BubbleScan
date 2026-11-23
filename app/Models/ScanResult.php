<?php

namespace App\Models;

use Database\Factories\ScanResultFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanResult extends Model
{
    /** @use HasFactory<ScanResultFactory> */
    use HasFactory;

    public const UPDATED_AT = null;

    protected $fillable = [
        'total_mcqs',
        'correct_count',
        'wrong_count',
        'score_percentage',
        'answer_key',
        'student_answers',
        'created_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_mcqs' => 'integer',
            'correct_count' => 'integer',
            'wrong_count' => 'integer',
            'score_percentage' => 'float',
            'answer_key' => 'array',
            'student_answers' => 'array',
            'created_at' => 'datetime',
        ];
    }
}
