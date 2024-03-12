<?php

use Illuminate\Support\Facades\Route;

Route::prefix('participant')->middleware('auth:student')->group(function() {
    Route::get('/projects/create/view', [App\Http\Controllers\Student\CreateProjectController::class, 'indexView'])->name('participant.projects.view');
    Route::get('/projects/create', [App\Http\Controllers\Student\CreateProjectController::class, 'index'])->name('participant.projects.create');

    Route::get('/projects/edit/{project}', [App\Http\Controllers\Student\CreateProjectController::class, 'editproject'])->name('participant.projects.edit');
    Route::get('/projects/edit/{project}/add-task', [App\Http\Controllers\Student\CreateProjectController::class, 'addProjectTask'])->name('participant.projects.task');

    Route::get('/projects/add-task', [App\Http\Controllers\Student\CreateProjectController::class, 'addTask'])->name('participant.projects.add-task');
    // Route::get('/projects/edit-task/{taskIndex}', [App\Http\Controllers\Student\CreateProjectController::class, 'editTask'])->name('participant.projects.edit-task');
    Route::get('/projects/edit-task/{project}/task/{ProjectSection}', [App\Http\Controllers\Student\CreateProjectController::class, 'editTask'])->name('participant.projects.edit-task');

    Route::patch('/projects/{project}', [App\Http\Controllers\Student\CreateProjectController::class, 'projectUpdate'])->name('participant.projects.update');
    Route::patch('/projects/edit/{project}/add-task/progress', [App\Http\Controllers\Student\CreateProjectController::class, 'addTaskProgress'])->name('participant.projects.task.progress');
    Route::patch('/projects/edit/{project}/edit-task/{ProjectSection}/progress', [App\Http\Controllers\Student\CreateProjectController::class, 'editTaskProgress'])->name('participant.projects.edit-task.progress');
    // Add this route for deleting a project section
    Route::get('/projects/del/{project}/task/{ProjectSection}', [App\Http\Controllers\Student\CreateProjectController::class, 'deleteProjectTask'])->name('participant.projects.task.delete');
    Route::get('/projects/enroll/{project}', [App\Http\Controllers\Student\CreateProjectController::class, 'enrollProject'])->name('participant.projects.task.enroll');
});
