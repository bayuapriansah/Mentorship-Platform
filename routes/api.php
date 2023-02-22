<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('institution/{id}', [InstitutionController::class, 'GetInstituionById'])->name('getInstitutionData');
Route::get('comment/{id}', [CommentController::class, 'getdatacomment'])->name('getdatacomment');
Route::get('student/project/{project}', [CommentController::class, 'getdatastudent'])->name('getdatastudent');
