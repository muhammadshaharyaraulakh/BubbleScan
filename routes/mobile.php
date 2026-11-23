<?php

use App\NativeComponents\CameraScreen;
use App\NativeComponents\ResultScreen;
use App\NativeComponents\ScanScreen;
use App\NativeComponents\Welcome;
use Illuminate\Support\Facades\Route;

Route::native('/', Welcome::class);
Route::native('/scan', ScanScreen::class);
Route::native('/camera', CameraScreen::class);
Route::native('/result', ResultScreen::class);
