<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;
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

// Home Page
Route::get('/', function () {
    return view('index');
})->name('index');

// register
Route::post('/register', [AuthController::class, 'store'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/sendmail', [MailController::class, 'index']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');

// Student projects page
// Route::group(['middleware'=>'auth:student'], function(){
Route::group(['middleware'=>'auth:student'], function(){
    // projects page
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/supportlib', function () {
        return view('projects.supportlibrary');
    })->name('projects.support');
});

Route::group(['middleware'=>['auth:web'], 'prefix'=>'dashboard','as'=>'dashboard.'], function(){
    // dashboard page
    
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    
    // Student
    Route::get('students/registered', [StudentController::class, 'registered'])->name('students.registered');
    Route::resource('students', StudentController::class);

    // Mentors
    Route::get('mentors/registered', [MentorController::class, 'registered'])->name('mentors.registered');
    Route::resource('mentors', MentorController::class);

    // Company/partner/supervisor
    Route::get('companies/registered', [CompanyController::class, 'registered'])->name('companies.registered');
    Route::resource('companies', CompanyController::class);

    // Project
    Route::get('/projects', [ProjectController::class, 'dashboardIndex'])->name('projects.index');
    Route::get('/projects/create', [ProjectController::class, 'dashboardIndexCreate'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'dashboardIndexStore'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'dashboardIndexEdit'])->name('projects.edit');
    Route::patch('/projects/{project}', [ProjectController::class, 'dashboardIndexUpdate'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'dashboardIndexDestroy'])->name('projects.destroy');
    



    // Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    // Route::get('/supportlib', function () {
    //     return view('projects.supportlibrary');
    // })->name('projects.support');
});
Route::group(['middleware'=>['auth:web,company'], 'prefix'=>'dashboard','as'=>'dashboard.'], function(){
    // Project
    Route::get('/projects', [ProjectController::class, 'dashboardIndex'])->name('projects.index');
    Route::get('/projects/create', [ProjectController::class, 'dashboardIndexCreate'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'dashboardIndexStore'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'dashboardIndexEdit'])->name('projects.edit');
    Route::patch('/projects/{project}', [ProjectController::class, 'dashboardIndexUpdate'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'dashboardIndexDestroy'])->name('projects.destroy');
});


// Route::get('/home', [DashboardController::class, 'index'])->name('home');
// Route::view('/home', 'layouts.index');


// Route::get('/q&a', function () {
//     return view('welcome');
// });

// Route::get('/studentprofilerepo', function () {
//     return view('welcome');
// });

// Route::get('/leaderboard', function () {
//     return view('welcome');
// });