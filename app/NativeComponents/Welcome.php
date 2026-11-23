<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class Welcome extends NativeComponent
{
    public bool $showContent = false;

    public function mount(): void
    {
        // Trigger content reveal after mount
        $this->showContent = true;
    }

    public function getStarted(): void
    {
        $this->navigate('/scan');
    }

    public function render(): View
    {
        return view('native.welcome');
    }
}
