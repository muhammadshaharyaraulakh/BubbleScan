<?php

namespace Tests\Feature;

use App\NativeComponents\CameraScreen;
use Native\Mobile\Events\Camera\PhotoTaken;
use Native\Mobile\Testing\Native;
use Tests\TestCase;

class CameraScreenTest extends TestCase
{
    public function test_renders_camera_viewfinder_screen(): void
    {
        Native::test(CameraScreen::class)
            ->assertSee('Scan Bubble Sheet')
            ->assertSee('Point camera at the filled bubble sheet')
            ->assertSee('Capture');
    }

    public function test_capture_triggers_camera_get_photo(): void
    {
        Native::test(CameraScreen::class)
            ->call('capture')
            ->assertNativeCalled('Camera.GetPhoto');
    }

    public function test_photo_taken_event_reveals_preview_and_process_button(): void
    {
        Native::test(CameraScreen::class)
            ->emitNative(PhotoTaken::class, [
                'path' => '/tmp/captured_photo.jpg',
            ])
            ->assertSet('imageCaptured', true)
            ->assertSet('capturedImage', '/tmp/captured_photo.jpg')
            ->assertSee('Sheet Captured Successfully')
            ->assertSee('Process & Get Results')
            ->assertSee('Retake');
    }

    public function test_retake_restores_capture_mode(): void
    {
        Native::test(CameraScreen::class)
            ->emitNative(PhotoTaken::class, [
                'path' => '/tmp/captured_photo.jpg',
            ])
            ->assertSet('imageCaptured', true)
            ->call('retake')
            ->assertSet('imageCaptured', false)
            ->assertSee('Capture');
    }

    public function test_process_image_navigates_to_result(): void
    {
        Native::test(CameraScreen::class)
            ->emitNative(PhotoTaken::class, [
                'path' => '/tmp/captured_photo.jpg',
            ])
            ->call('processImage')
            ->assertNavigatedTo('/result');
    }

    public function test_go_back_navigates_to_scan(): void
    {
        Native::test(CameraScreen::class)
            ->call('goBack')
            ->assertNavigatedTo('/scan');
    }
}
