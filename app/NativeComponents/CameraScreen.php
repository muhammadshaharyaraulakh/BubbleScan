<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Attributes\On;
use Native\Mobile\Edge\NativeComponent;
use Native\Mobile\Events\Camera\PhotoTaken;
use Native\Mobile\Facades\Camera;

class CameraScreen extends NativeComponent
{
    public string $capturedImage = '';

    public bool $imageCaptured = false;

    public string $answerKey = '';

    public string $totalMcqs = '';

    public function mount(): void
    {
        $this->answerKey = (string) $this->data('answerKey', session('answer_key', ''));
        $this->totalMcqs = (string) $this->data('totalMcqs', session('total_mcqs', ''));

        if ($this->answerKey === '') {
            $this->answerKey = 'A,B,C,D,A,B,C,D,A,B';
            $this->totalMcqs = '10';
        }
    }

    public function capture(): void
    {
        Camera::getPhoto();
    }

    #[On(PhotoTaken::class)]
    public function onPhotoTaken(string $path): void
    {
        $this->imageCaptured = true;
        $this->capturedImage = $path;
        session(['captured_image' => $this->capturedImage]);
    }

    public function retake(): void
    {
        $this->imageCaptured = false;
        $this->capturedImage = '';
        session()->forget('captured_image');
    }

    public function processImage(): void
    {
        $this->navigate('/result', [
            'answerKey' => $this->answerKey,
            'totalMcqs' => $this->totalMcqs,
            'capturedImage' => $this->capturedImage,
        ]);
    }

    public function goBack(): void
    {
        $this->navigate('/scan');
    }

    public function render(): View
    {
        return view('native.camera-screen');
    }
}
