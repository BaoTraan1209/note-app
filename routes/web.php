<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');

    Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create');
    Route::post('/notes/store', [NoteController::class, 'store'])->name('notes.store');

    Route::get('/notes/{noteId}', [NoteController::class, 'show'])->name('notes.show');

//    Route::get('/notes/{noteId}/edit', [NoteController::class, 'edit'])->name('notes.edit');
    Route::put('/notes/{noteId}', [NoteController::class, 'update'])->name('notes.update');

    Route::delete('/notes/{noteId}', [NoteController::class, 'destroy'])->name('notes.destroy');

    Route::resource('labels', LabelController::class);


});

require __DIR__.'/auth.php';
