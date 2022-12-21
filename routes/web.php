<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MajortController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RegisterController;
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



// register
Route::post('/register', [RegisterController::class, 'store'])->name('register');
Route::post('/logout', [RegisterController::class, 'logout'])->name('logout');

// Home Page
Route::get('/', function () {
    return view('index');
})->name('index');

// projects page
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');

// Route::get('/home', [DashboardController::class, 'index'])->name('home');
Route::view('/home', 'layouts.index');

Route::get('/signin', function () {
    return view('welcome');
});

Route::get('/signup', function () {
    return view('welcome');
});

Route::get('/supportlib', function () {
    return view('supportlibrary');
})->name('supportlib');

Route::get('/q&a', function () {
    return view('welcome');
});

Route::get('/studentprofilerepo', function () {
    return view('welcome');
});

Route::get('/leaderboard', function () {
    return view('welcome');
});