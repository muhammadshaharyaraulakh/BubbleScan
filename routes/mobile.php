<?php

use App\NativeComponents\Welcome;
use Illuminate\Support\Facades\Route;

Route::native('/', Welcome::class);
