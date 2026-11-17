<?php

namespace Tests\Feature;

use App\NativeComponents\Welcome;
use Native\Mobile\Testing\Native;
use Tests\TestCase;

class WelcomeTest extends TestCase
{
    public function test_renders_the_welcome_screen_with_app_branding(): void
    {
        Native::test(Welcome::class)
            ->assertSee('BubbleScan')
            ->assertSee('Scan. Grade. Done.')
            ->assertSee('Instant Scanning')
            ->assertSee('Smart Analytics')
            ->assertSee('Accurate Grading')
            ->assertSee('Get Started');
    }

    public function test_sets_show_content_to_true_on_mount(): void
    {
        Native::test(Welcome::class)
            ->assertSet('showContent', true);
    }
}
