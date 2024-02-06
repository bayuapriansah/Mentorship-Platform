<?php

use Illuminate\Support\Facades\Route;

Route::prefix('participant')->middleware('auth:student')->group(function() {
    Route::get('/projects/create', [App\Http\Controllers\Student\CreateProjectController::class, 'index'])->name('participant.projects.create');
    Route::get('/projects/add-task', [App\Http\Controllers\Student\CreateProjectController::class, 'addTask'])->name('participant.projects.add-task');
    Route::get('/projects/edit-task/{taskIndex}', [App\Http\Controllers\Student\CreateProjectController::class, 'editTask'])->name('participant.projects.edit-task');
});
