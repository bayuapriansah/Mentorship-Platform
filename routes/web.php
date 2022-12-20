<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\MajortController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UniversityController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Home Page

Route::get('/home', function () {
    return view('welcome');
});

Route::get('/project', function () {
    return view('welcome');
});

Route::get('/signin', function () {
    return view('welcome');
});

Route::get('/signup', function () {
    return view('welcome');
});

Route::get('/supportlib', function () {
    return view('welcome');
});

Route::get('/q&a', function () {
    return view('welcome');
});

Route::get('/studentprofilerepo', function () {
    return view('welcome');
});

Route::get('/leaderboard', function () {
    return view('welcome');
});

// Admin
Route::get('/leaderboard', [UserController::class, 'index']);