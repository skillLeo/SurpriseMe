<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\VoiceController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\GiftController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/start', [SubmissionController::class, 'index'])->name('form');
Route::post('/start', [SubmissionController::class, 'store'])->name('form.store');

Route::get('/record', [VoiceController::class, 'index'])->name('voice');
Route::post('/voice/upload', [VoiceController::class, 'upload'])->name('voice.upload');
Route::get('/listen/{token}', [VoiceController::class, 'listen'])->name('voice.listen');

Route::get('/share', [ShareController::class, 'index'])->name('share');

Route::get('/gifts', [GiftController::class, 'show'])->name('gift');



// Replace your old  Route::post('/form', ...)  with these three:
    Route::get('/form',          [SubmissionController::class, 'index'])  ->name('form');
    Route::post('/form/preview', [SubmissionController::class, 'preview'])->name('form.preview');
    Route::post('/form/confirm', [SubmissionController::class, 'confirm'])->name('form.confirm');
    Route::post('/form/cancel',  [SubmissionController::class, 'cancel']) ->name('form.cancel');
    
    // All other routes stay the same