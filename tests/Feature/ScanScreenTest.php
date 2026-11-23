<?php

namespace Tests\Feature;

use App\NativeComponents\ScanScreen;
use Native\Mobile\Testing\Native;
use Tests\TestCase;

class ScanScreenTest extends TestCase
{
    public function test_renders_setup_answer_key_screen(): void
    {
        Native::test(ScanScreen::class)
            ->assertSee('Setup Answer Key')
            ->assertSee('Number of MCQs')
            ->assertSee('Answers Sequence')
            ->assertSee('Save');
    }

    public function test_validation_error_on_mismatch_between_mcqs_and_answers_count(): void
    {
        Native::test(ScanScreen::class)
            ->set('totalMcqs', '5')
            ->set('input', 'A,B,C,D')
            ->call('saveKey')
            ->assertSet('keySaved', false)
            ->assertSet('errorMessage', 'You entered 4 answers but total MCQs is 5. Please check again.')
            ->assertSee('You entered 4 answers but total MCQs is 5. Please check again.');
    }

    public function test_validation_error_when_answers_contain_invalid_options(): void
    {
        Native::test(ScanScreen::class)
            ->set('totalMcqs', '3')
            ->set('input', 'A,B,X')
            ->call('saveKey')
            ->assertSet('keySaved', false)
            ->assertSee('Only A, B, C, D answers are allowed');
    }

    public function test_valid_save_shows_answer_key_card_and_scan_now_button(): void
    {
        Native::test(ScanScreen::class)
            ->set('totalMcqs', '5')
            ->set('input', 'A,B,C,D,A')
            ->call('saveKey')
            ->assertSet('keySaved', true)
            ->assertSet('answerKey', 'A,B,C,D,A')
            ->assertSee('Answer Key (5 Questions)')
            ->assertSee('Scan Now');
    }

    public function test_delete_key_resets_form(): void
    {
        Native::test(ScanScreen::class)
            ->set('totalMcqs', '4')
            ->set('input', 'A,B,C,D')
            ->call('saveKey')
            ->assertSet('keySaved', true)
            ->call('deleteKey')
            ->assertSet('keySaved', false)
            ->assertSet('answerKey', '')
            ->assertSee('Setup Answer Key')
            ->assertSee('Save');
    }

    public function test_scan_now_navigates_to_camera(): void
    {
        Native::test(ScanScreen::class)
            ->set('totalMcqs', '4')
            ->set('input', 'A,B,C,D')
            ->call('saveKey')
            ->call('scanNow')
            ->assertNavigatedTo('/camera');
    }

    public function test_go_back_navigates_to_home(): void
    {
        Native::test(ScanScreen::class)
            ->call('goBack')
            ->assertNavigatedTo('/');
    }
}
