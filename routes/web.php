<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\IssueController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('projects', ProjectController::class);

Route::get('/issues/{issue}/comments', [CommentController::class, 'index'])->name('issues.comments');
Route::post('/issues/{issue}/comments', [CommentController::class, 'store'])->name('issues.comments.store');

Route::resource('issues', \App\Http\Controllers\IssueController::class);

Route::post('/issues/{issue}/attach-tag', [IssueController::class,'attachTag'])->name('issues.attachTag');
Route::post('/issues/{issue}/detach-tag', [IssueController::class,'detachTag'])->name('issues.detachTag');
