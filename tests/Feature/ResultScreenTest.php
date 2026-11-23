<?php

namespace Tests\Feature;

use App\Models\ScanResult;
use App\NativeComponents\ResultScreen;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Native\Mobile\Testing\Native;
use Tests\TestCase;

class ResultScreenTest extends TestCase
{
    use RefreshDatabase;

    public function test_renders_score_summary_and_detailed_report(): void
    {
        Native::test(ResultScreen::class)
            ->assertSee('Grading Results')
            ->assertSee('SCORE')
            ->assertDontSee('Wrong:')
            ->assertSee('Detailed Report Table')
            ->assertSee('Scan Another')
            ->assertSee('Home');
    }

    public function test_calculates_score_accurately_and_generates_report_rows(): void
    {
        $component = Native::test(ResultScreen::class);

        $total = $component->get('totalMcqs');
        $correct = $component->get('correctCount');
        $wrong = $component->get('wrongCount');
        $score = $component->get('scorePercentage');

        $this->assertSame($total, $correct + $wrong);
        $this->assertEquals(round(($correct / $total) * 100, 1), $score);
    }

    public function test_automatically_persists_scan_result_to_sqlite(): void
    {
        $this->assertDatabaseCount('scan_results', 0);

        Native::test(ResultScreen::class);

        $this->assertDatabaseCount('scan_results', 1);

        $record = ScanResult::first();
        $this->assertNotNull($record);
        $this->assertGreaterThan(0, $record->total_mcqs);
        $this->assertIsArray($record->answer_key);
        $this->assertIsArray($record->student_answers);
        $this->assertNotNull($record->created_at);
    }

    public function test_scan_another_navigates_to_scan(): void
    {
        Native::test(ResultScreen::class)
            ->call('scanAnother')
            ->assertNavigatedTo('/scan');
    }

    public function test_go_home_navigates_to_welcome(): void
    {
        Native::test(ResultScreen::class)
            ->call('goHome')
            ->assertNavigatedTo('/');
    }
}
