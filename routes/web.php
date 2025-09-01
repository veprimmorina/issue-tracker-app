<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('projects', ProjectController::class);
});

Route::middleware(['auth'])->prefix('issues')->name('issues.')->group(function () {
    Route::get('/', [IssueController::class, 'index'])->name('index');
    Route::get('/create', [IssueController::class, 'create'])->name('create');
    Route::post('/', [IssueController::class, 'store'])->name('store');
    Route::get('/{issue}', [IssueController::class, 'show'])->name('show');
    Route::get('/{issue}/edit', [IssueController::class, 'edit'])->name('edit');
    Route::put('/{issue}', [IssueController::class, 'update'])->name('update');
    Route::delete('/{issue}', [IssueController::class, 'destroy'])->name('destroy');

    Route::post('/{issue}/attach-tag', [IssueController::class, 'attachTag'])->name('attach-tag');
    Route::post('/{issue}/detach-tag', [IssueController::class, 'detachTag'])->name('detach-tag');

    Route::post('/{issue}/users', [IssueController::class, 'attachUser'])->name('users.attach');
    Route::delete('/{issue}/users/{user}', [IssueController::class, 'detachUser'])->name('users.detach');

    Route::get('/{issue}/comments', [CommentController::class, 'index'])->name('comments');
    Route::post('/{issue}/comments', [CommentController::class, 'store'])->name('comments.store');
});

Route::middleware(['auth'])->resource('tags', TagController::class);

require __DIR__.'/auth.php';
