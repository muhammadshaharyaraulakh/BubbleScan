<?php

namespace Database\Factories;

use App\Models\ScanResult;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ScanResult>
 */
class ScanResultFactory extends Factory
{
    protected $model = ScanResult::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $options = ['A', 'B', 'C', 'D'];
        $total = 10;
        $answerKey = [];
        $studentAnswers = [];
        $correct = 0;

        for ($i = 0; $i < $total; $i++) {
            $key = fake()->randomElement($options);
            $answerKey[] = $key;
            $isCorrect = $i < 7;
            if ($isCorrect) {
                $studentAnswers[] = $key;
                $correct++;
            } else {
                $wrongOptions = array_values(array_diff($options, [$key]));
                $studentAnswers[] = fake()->randomElement($wrongOptions);
            }
        }

        $wrong = $total - $correct;
        $score = round(($correct / $total) * 100, 1);

        return [
            'total_mcqs' => $total,
            'correct_count' => $correct,
            'wrong_count' => $wrong,
            'score_percentage' => $score,
            'answer_key' => $answerKey,
            'student_answers' => $studentAnswers,
            'created_at' => now(),
        ];
    }
}
