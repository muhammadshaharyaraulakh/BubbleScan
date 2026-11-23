<?php

namespace App\NativeComponents;

use App\Models\ScanResult;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class ResultScreen extends NativeComponent
{
    public int $totalMcqs = 0;

    public int $correctCount = 0;

    public int $wrongCount = 0;

    public float $scorePercentage = 0.0;

    /** @var list<string> */
    public array $answerKeyList = [];

    /** @var list<string> */
    public array $studentAnswersList = [];

    /** @var list<array{question: int, student_answer: string, correct_answer: string, is_correct: bool}> */
    public array $reportRows = [];

    public bool $resultSaved = false;

    public function mount(): void
    {
        $rawKey = (string) $this->data('answerKey', session('answer_key', ''));

        if ($rawKey !== '') {
            $items = preg_split('/[\s,]+/', $rawKey, -1, PREG_SPLIT_NO_EMPTY);
            $this->answerKeyList = array_map(fn (string $item): string => strtoupper(trim($item)), $items ?: []);
        } else {
            $this->answerKeyList = ['A', 'B', 'C', 'D', 'A', 'B', 'C', 'D', 'A', 'B'];
        }

        $this->totalMcqs = count($this->answerKeyList);

        $passedAnswers = $this->data('studentAnswers');
        if (is_array($passedAnswers) && count($passedAnswers) === $this->totalMcqs) {
            $this->studentAnswersList = array_values($passedAnswers);
        } else {
            $this->studentAnswersList = $this->generateStudentAnswers($this->answerKeyList);
        }

        $this->calculateScore();

        if (! $this->resultSaved && $this->totalMcqs > 0) {
            ScanResult::create([
                'total_mcqs' => $this->totalMcqs,
                'correct_count' => $this->correctCount,
                'wrong_count' => $this->wrongCount,
                'score_percentage' => $this->scorePercentage,
                'answer_key' => $this->answerKeyList,
                'student_answers' => $this->studentAnswersList,
                'created_at' => now(),
            ]);

            $this->resultSaved = true;
        }
    }

    public function calculateScore(): void
    {
        $this->correctCount = 0;
        $this->wrongCount = 0;
        $this->reportRows = [];

        foreach ($this->answerKeyList as $idx => $correctAns) {
            $studentAns = $this->studentAnswersList[$idx] ?? 'A';
            $isCorrect = ($studentAns === $correctAns);

            if ($isCorrect) {
                $this->correctCount++;
            } else {
                $this->wrongCount++;
            }

            $this->reportRows[] = [
                'question' => $idx + 1,
                'student_answer' => $studentAns,
                'correct_answer' => $correctAns,
                'is_correct' => $isCorrect,
            ];
        }

        $this->scorePercentage = $this->totalMcqs > 0
            ? round(($this->correctCount / $this->totalMcqs) * 100, 1)
            : 0.0;
    }

    /**
     * @param  list<string>  $answerKey
     * @return list<string>
     */
    protected function generateStudentAnswers(array $answerKey): array
    {
        $options = ['A', 'B', 'C', 'D'];
        $total = count($answerKey);

        // Approximate 70% accuracy (e.g. 3 wrong out of 10)
        $targetWrong = (int) round($total * 0.3);
        $wrongIndices = [];

        if ($total > 0 && $targetWrong > 0) {
            $step = max(1, (int) floor($total / $targetWrong));
            for ($w = 0; $w < $targetWrong; $w++) {
                $idx = min($total - 1, ($w * $step) + 1);
                $wrongIndices[$idx] = true;
            }
        }

        $studentAnswers = [];
        foreach ($answerKey as $i => $correctOption) {
            if (isset($wrongIndices[$i])) {
                $wrongOptions = array_values(array_diff($options, [$correctOption]));
                $studentAnswers[] = $wrongOptions[0] ?? 'A';
            } else {
                $studentAnswers[] = $correctOption;
            }
        }

        return $studentAnswers;
    }

    public function scanAnother(): void
    {
        $this->navigate('/scan');
    }

    public function goHome(): void
    {
        $this->navigate('/');
    }

    public function render(): View
    {
        return view('native.result-screen');
    }
}
