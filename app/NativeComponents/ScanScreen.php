<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class ScanScreen extends NativeComponent
{
    public string $totalMcqs = '';

    public string $input = '';

    public string $answerKey = '';

    public bool $keySaved = false;

    public string $errorMessage = '';

    public function mount(): void
    {
        $savedKey = (string) session('answer_key', '');
        $savedTotal = (string) session('total_mcqs', '');

        if ($savedKey !== '' && $savedTotal !== '') {
            $this->answerKey = $savedKey;
            $this->totalMcqs = $savedTotal;
            $this->input = $savedKey;
            $this->keySaved = true;
        }
    }

    public function saveKey(?string $submitted = null): void
    {
        $rawInput = trim($submitted ?? $this->input);
        $this->errorMessage = '';

        $total = (int) trim($this->totalMcqs);
        if ($total <= 0) {
            $this->errorMessage = 'Please enter a valid number of MCQs.';

            return;
        }

        if ($rawInput === '') {
            $this->errorMessage = 'Please enter the answers sequence.';

            return;
        }

        $items = preg_split('/[\s,]+/', $rawInput, -1, PREG_SPLIT_NO_EMPTY);
        $answers = array_map(fn (string $item): string => strtoupper(trim($item)), $items ?: []);
        $count = count($answers);

        if ($count !== $total) {
            $this->errorMessage = "You entered {$count} answers but total MCQs is {$total}. Please check again.";

            return;
        }

        foreach ($answers as $ans) {
            if (! in_array($ans, ['A', 'B', 'C', 'D'], true)) {
                $this->errorMessage = 'Only A, B, C, D answers are allowed. Please check your entries.';

                return;
            }
        }

        $this->keySaved = true;
        $this->answerKey = implode(',', $answers);
        $this->errorMessage = '';

        session([
            'answer_key' => $this->answerKey,
            'total_mcqs' => (string) $total,
        ]);
    }

    public function deleteKey(): void
    {
        $this->keySaved = false;
        $this->answerKey = '';
        $this->errorMessage = '';

        session()->forget(['answer_key', 'total_mcqs']);
    }

    public function scanNow(): void
    {
        $this->navigate('/camera', [
            'answerKey' => $this->answerKey,
            'totalMcqs' => $this->totalMcqs,
        ]);
    }

    public function goBack(): void
    {
        $this->navigate('/');
    }

    public function render(): View
    {
        return view('native.scan-screen');
    }
}
