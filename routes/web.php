<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\NotePasswordController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::view('/offline', 'offline')->name('offline');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');

    Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create');
    Route::post('/notes/store', [NoteController::class, 'store'])->name('notes.store');

    Route::get('/notes/{noteId}', [NoteController::class, 'show'])->name('notes.show');
    Route::patch('/notes/{noteId}/pin', [NoteController::class, 'togglePin'])->name('notes.pin');
    Route::put('/notes/{noteId}', [NoteController::class, 'update'])->name('notes.update');

    Route::delete('/notes/{noteId}', [NoteController::class, 'destroy'])->name('notes.destroy');

    Route::get('/notes/{noteId}/password', [NotePasswordController::class, 'edit'])->name('notes.password.edit');
    Route::post('/notes/{noteId}/password', [NotePasswordController::class, 'update'])->name('notes.password.update');
    Route::delete('/notes/{noteId}/password', [NotePasswordController::class, 'destroy'])->name('notes.password.destroy');
    Route::get('/notes/{noteId}/unlock', [NotePasswordController::class, 'unlockForm'])->name('notes.password.unlock-form');
    Route::post('/notes/{noteId}/unlock', [NotePasswordController::class, 'unlock'])->name('notes.password.unlock');

    Route::get('/notes/{noteId}/share', [NoteController::class, 'shareEdit'])->name('notes.share.edit');
    Route::post('/notes/{noteId}/share', [NoteController::class, 'share'])->name('notes.share.store');
    Route::patch('/notes/{noteId}/share/{shareId}', [NoteController::class, 'updateShare'])->name('notes.share.update');
    Route::delete('/notes/{noteId}/share/{shareId}', [NoteController::class, 'destroyShare'])->name('notes.share.destroy');
    Route::get('/shared', [NoteController::class, 'shared'])->name('shared.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/preferences', [PreferenceController::class, 'edit'])->name('preferences.edit');
    Route::patch('/preferences', [PreferenceController::class, 'update'])->name('preferences.update');
});

require __DIR__.'/auth.php';

