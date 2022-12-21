<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\MailController;

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
Route::post('/register', [AuthController::class, 'store'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/sendmail', [MailController::class, 'index']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');

// Student projects page
// Route::group(['middleware'=>'auth:student'], function(){
Route::group(['middleware'=>'auth:student, company'], function(){
    // projects page
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/supportlib', function () {
        return view('projects.supportlibrary');
    })->name('projects.support');
    
});

// Home Page
Route::get('/', function () {
    return view('index');
})->name('index');

// Route::get('/home', [DashboardController::class, 'index'])->name('home');
Route::view('/home', 'layouts.index');

Route::get('/signin', function () {
    return view('welcome');
});

Route::get('/signup', function () {
    return view('welcome');
});



Route::get('/project/detail-project', function () {
    return view('detail-project');
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