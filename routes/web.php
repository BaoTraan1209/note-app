<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/notes', [NoteController::class, 'index'])->name('notes'); // GET http://127.0.0.1:8000/notes

    Route::get('/notes/create', [NoteController::class, 'createView'])->name('notes.store-view'); // GET http://127.0.0.1:8000/notes/create
    Route::post('/notes/create', [NoteController::class, 'store'])->name('notes.store'); // POST http://127.0.0.1:8000/notes/create
});

require __DIR__.'/auth.php';
