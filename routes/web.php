<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/todo', [TodoController::class, 'index'])->name('todo.index');
    Route::post('/todo', [TodoController::class, 'store'])->name('todo.store');
    Route::get('/todo/{idTodo}/edit', [TodoController::class, 'edit'])->name('todo.edit');
    Route::put('/todo/{idTodo}/edit', [TodoController::class, 'update']);
    Route::patch('/todo/{idTodo}/done', [TodoController::class, 'updateDone'])->name('todo.complete');
    Route::delete('/todo/{idTodo}/delete', [TodoController::class, 'destroy'])->name('todo.destroy');

});

require __DIR__.'/auth.php';
