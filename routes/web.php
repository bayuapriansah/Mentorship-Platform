<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\SimintEncryption;
use App\Http\Controllers\AuthOtpController;
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

// mentor register
Route::get('/mentor/register/{mentor_id}', [MentorController::class, 'register'])->name('mentor.register');
Route::post('/mentor/register/{mentor_id}/auth', [MentorController::class, 'update'])->name('mentor.registerAuth');

// student register
Route::get('/student/register/{student_id}', [StudentController::class, 'register'])->name('student.register');
Route::post('/student/register/{student_id}/auth', [StudentController::class, 'update'])->name('student.registerAuth');

// Student projects page
Route::group(['middleware'=>'auth:student'], function(){
    // projects page
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{project}/detail/{subsection}',[ProjectController::class, 'showSubsection'])->name('projects.subsection');
    Route::get('/projects/{student}/applied', [ProjectController::class, 'applied'])->name('projects.applied');
    Route::get('/projects/{student}/applied/{project}/detail', [ProjectController::class, 'appliedDetail'])->name('projects.appliedDetail');
    Route::get('/projects/{student}/applied/{project}/detail/{subsection}/submission', [ProjectController::class, 'appliedSubmission'])->name('projects.appliedSubmission');
    Route::post('/projects/{student}/applied/{project}/detail/{subsection}', [ProjectController::class, 'appliedSubmit'])->name('projects.appliedSubmit');
    Route::post('/projects/{project}/apply', [ProjectController::class, 'applyProject'])->name('projects.apply');
    Route::get('/supportlib', function () {
        return view('projects.supportlibrary');
    })->name('projects.support');
});

Route::group(['prefix'=>'dashboard','as'=>'dashboard.'], function(){
    // dashboard page
    
    Route::middleware(['auth:web'])->group(function(){
        Route::get('/admin', [DashboardController::class, 'index'])->name('admin');
        // Student
        Route::get('students/registered', [StudentController::class, 'registered'])->name('students.registered');
        Route::resource('students', StudentController::class);

        // Mentors
        Route::get('mentors/registered', [MentorController::class, 'registered'])->name('mentors.registered');
        Route::get('mentors/registered/{company_id}/invite', [MentorController::class, 'invite'])->name('mentors.invite');
        Route::post('mentors/registered/{company_id}/invite', [MentorController::class, 'sendInvite'])->name('mentors.sendinvite');
        Route::resource('mentors', MentorController::class);

        // Company/partner/supervisor
        Route::get('companies/registered', [CompanyController::class, 'registered'])->name('companies.registered');
        Route::resource('companies', CompanyController::class);
    });
    
    Route::middleware(['auth:web,company'])->group(function(){
        Route::get('/company', [DashboardController::class, 'indexCompany'])->name('company');

        // Project
        Route::get('/projects', [ProjectController::class, 'dashboardIndex'])->name('projects.index');
        Route::get('/projects/draft', [ProjectController::class, 'draftIndex'])->name('projects.draft');
        Route::get('/projects/create', [ProjectController::class, 'dashboardIndexCreate'])->name('projects.create');
        Route::post('/projects', [ProjectController::class, 'dashboardIndexStore'])->name('projects.store');
        Route::get('/projects/{project}/edit', [ProjectController::class, 'dashboardIndexEdit'])->name('projects.edit');
        Route::patch('/projects/{project}', [ProjectController::class, 'dashboardIndexUpdate'])->name('projects.update');
        Route::patch('projects/{project}/publish', [ProjectController::class, 'publish'])->name('project.publish');
        Route::delete('/projects/{project}', [ProjectController::class, 'dashboardIndexDestroy'])->name('projects.destroy');

        //section
        Route::get('/projects/{project}/section', [ProjectController::class, 'dashboardIndexSection'])->name('projects.section');
        Route::post('/projects/{project}', [ProjectController::class, 'dashboardIndexStoreSection'])->name('projects.storeSection');
        Route::get('/projects/{project}/section/{section}/edit', [ProjectController::class, 'dashboardIndexEditSection'])->name('projects.EditSection');
        Route::patch('/projects/{project}/section/{section}', [ProjectController::class, 'dashboardIndexUpdateSection'])->name('projects.UpdateSection');
        Route::delete('/projects/{project}/section/{section}', [ProjectController::class, 'dashboardIndexDestroySection'])->name('projects.DestroySection');
        
        //subsection
        Route::get('/projects/{project}/section/{section}/subsection', [ProjectController::class, 'dashboardIndexSubsection'])->name('projects.subsection');
        Route::get('/projects/{project}/section/{section}/create', [ProjectController::class, 'dashboardCreateSubsection'])->name('projects.storeSubsection');
        Route::post('/projects/{project}/section/{section}', [ProjectController::class, 'dashboardStoreSubsection'])->name('projects.storeSubsection');
        Route::get('/projects/{project}/section/{section}/subsection/{subsection}/edit', [ProjectController::class, 'dashboardEditSubsection'])->name('projects.EditSubsection');
        Route::patch('/projects/{project}/section/{section}/subsection/{subsection}', [ProjectController::class, 'dashboardUpdateSubsection'])->name('projects.UpdateSubsection');
        Route::delete('/projects/{project}/section/{section}/subsection/{subsection}', [ProjectController::class, 'dashboardDestroySubsection'])->name('projects.DestroySubsection');
    });
    Route::middleware(['auth:mentor'])->group(function(){
        Route::get('/mentor', [DashboardController::class, 'indexMentor'])->name('mentor');

        Route::get('/assigned_projects',[MentorController::class, 'indexAssigned'])->name('assigned.index');
        Route::get('/assigned_projects/{project}/section', [MentorController::class, 'sectionProjectAssign'])->name('assigned.projectSection');
        Route::get('/assigned_projects/{project}/section/{section}/subsection', [MentorController::class, 'subsectionProjectAssign'])->name('assigned.projectSubsection');
        Route::post('/grade/{submission}', [GradeController::class, 'subsectionProjectGradeAssign'])->name('assigned.projectSubsectionGrade');

    });
});

Route::get('/testEnkripsi', [SimintEncryption::class, 'enkripsi']);

Route::controller(AuthOtpController::class)->group(function(){
    Route::get('/otp/login', 'login')->name('otp.login');
    Route::post('/otp/generate', 'generate')->name('otp.generate');
    Route::get('/otp/verification/{user_id}/{email}', 'verification')->name('otp.verification');
    Route::post('/otp/login', 'loginWithOtp')->name('otp.getlogin');
});