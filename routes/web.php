<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\AssignController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\SimintEncryption;
use App\Http\Controllers\AuthOtpController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TheWorldController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\InstitutionController;

/*
|--------------------------------------(------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Static Page
Route::get('/emailtemp', function () {
    return view('emails.otp');
});
Route::get('/supportlib', function () {
    return view('projects.supportlibrary');
})->name('projects.support');
Route::get('/faq', function () {
    return view('faq');
})->name('faq');
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');
Route::get('/terms-of-use', function () {
    return view('terms-of-use');
})->name('terms-of-use');
Route::get('/adminpage', function () {
    return view('adminpage');
})->name('adminpage');
// Home Page
// Route::get('/', function () {
//     return view('index');
// })->name('index');
Route::get('/', [IndexController::class, 'index'])->name('index');
// for debugging temp
Route::get('/ccc/{student}/{project}', [ProjectController::class, 'appliedDetail'])->name('ccc');
// register
Route::get('/verify/{email}', [AuthController::class, 'verifyEmail'])->name('verify');
Route::get('/verified/{email}', [AuthController::class, 'verified'])->name('verified');
Route::get('/register', [AuthController::class, 'register'])->name('registerPage');
Route::post('/register', [AuthController::class, 'store'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/sendmail', [MailController::class, 'index']);
Route::get('/admin', [AuthController::class, 'login'])->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');

// mentor register
Route::get('/mentor/register/{email}', [MentorController::class, 'register'])->name('mentor.register');
Route::post('/mentor/register/{email}/auth', [MentorController::class, 'update'])->name('mentor.registerAuth');

// student register
Route::get('/register/student/{email}', [StudentController::class, 'register'])->name('student.register');
Route::post('/register/student/{email}', [StudentController::class, 'completedRegister'])->name('student.register.completed');
Route::post('/mentor/register/{email}/auth', [StudentController::class, 'update'])->name('mentor.registerAuth');


// bay
Route::group(['middleware'=>'auth:student'], function(){
    Route::get('/profile/{student}/allProjects', [StudentController::class, 'allProjects'])->name('student.allProjects');
    Route::get('/profile/{student}/allProjectsAvailable', [StudentController::class, 'allProjectsAvailable'])->name('student.allProjectsAvailable');
    Route::get('/profile/{student}/ongoingProjects', [StudentController::class, 'ongoingProjects'])->name('student.ongoingProjects');
    Route::get('/profile/{student}/completedProjects', [StudentController::class, 'completedProjects'])->name('student.completedProjects');
    Route::get('/profile/{student}/enrolled/{project}/detail', [StudentController::class, 'enrolledDetail'])->name('student.enrolledDetail');
    Route::get('/profile/{student}/enrolled/{project}/task/{task}', [StudentController::class, 'taskDetail'])->name('student.taskDetail');
    Route::post('/profile/{student}/enrolled/{project}/task/{task}', [StudentController::class, 'taskSubmit'])->name('student.taskSubmit');

    Route::get('/profile/{student}/allProjectsAvailable/{project}/detail', [StudentController::class, 'availableProjectDetail'])->name('student.availableProjectDetail');
    // Route::get('/projects/{student}/applied/{project}/detail', [ProjectController::class, 'appliedDetail'])->name('projects.appliedDetail');
    Route::post('/profile/{student}/enrolled/{project}/task/{task}/chat', [CommentController::class, 'store'])->name('comment.store');

    Route::get('/profile/{student}/edit', [StudentController::class, 'edit'])->name('student.edit');
    Route::patch('/profile/{student}', [StudentController::class, 'update'])->name('student.update');
});
// Student projects page
// Route::group(['middleware'=>'auth:student'], function(){
    // projects page
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/search', [ProjectController::class, 'search'])->name('projects.search');

Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show')->middleware('auth:student');
Route::get('/projects/{project}/detail/{subsection}',[ProjectController::class, 'showSubsection'])->name('projects.subsection');
// Route::get('/projects/{student}/applied', [ProjectController::class, 'applied'])->name('projects.applied');
// Route::get('/projects/{student}/applied/{project}/detail', [ProjectController::class, 'appliedDetail'])->name('projects.appliedDetail');
Route::get('/projects/{student}/applied/{project}/task/{section}/detail/{subsection}/submission', [ProjectController::class, 'appliedSubmission'])->name('projects.appliedSubmission');
Route::post('/projects/{student}/applied/{project}/detail/{subsection}', [ProjectController::class, 'appliedSubmit'])->name('projects.appliedSubmit');
Route::group(['middleware'=>'auth:student'], function(){
    Route::post('/projects/{project}/apply', [ProjectController::class, 'applyProject'])->name('projects.apply');
});


Route::get('/theworld', [TheWorldController::class, 'index']);

Route::group(['prefix'=>'dashboard','as'=>'dashboard.'], function(){
    // dashboard page

    Route::middleware(['auth:web'])->group(function(){
        Route::get('/admin', [DashboardController::class, 'index'])->name('admin');
        // Student
        Route::get('/students/invite', [StudentController::class, 'inviteFromInstitution' ])->name('students.invite');
        Route::get('/institutions/{institution}/students/{student}/manage', [StudentController::class, 'manage' ])->name('students.manage');
        Route::patch('/institutions/{institution}/students/{student}/managepatch', [StudentController::class, 'managepatch' ])->name('students.managepatch');
        Route::post('/institutions/{institution}/students/{student}/suspend', [StudentController::class, 'suspendAccount' ])->name('students.suspendAccount');
        Route::resource('students', StudentController::class);

        // Institution
        // Route::post('institutions/{institution}/edit/confirm', [InstitutionController::class, 'update'])->name('institutions.update.confirm');
        Route::get('/institutions_partners', [InstitutionController::class, 'institutions_partners'])->name('institutions_partners');
        Route::get('/institutions/{institution}/students', [InstitutionController::class, 'institutionStudents'])->name('students.institutionStudents');

        Route::get('/institutions/{institution}/students/invite', [StudentController::class, 'inviteFromInstitution'])->name('students.inviteFromInstitution');
        Route::post('/institutions/{institution}/students', [StudentController::class, 'sendInviteFromInstitution'])->name('students.sendInviteFromInstitution');
        Route::post('/institutions/students', [StudentController::class, 'sendInvite'])->name('students.sendInvite');

        Route::get('/institutions/{institution}/supervisors', [MentorController::class, 'index'])->name('institutionSupervisors');
        Route::get('/institutions/{institution}/supervisors/invite', [MentorController::class, 'invite'])->name('institutionSupervisorInvite');
        Route::post('/institutions/{institution}/supervisors', [MentorController::class, 'sendInvite'])->name('mentors.institutionSupervisorSendInvite');


        Route::post('/institutions/{institution}/suspend', [InstitutionController::class, 'suspendInstitution'])->name('institutions.suspend');
        Route::resource('institutions', InstitutionController::class);

        // Mentors
        Route::get('mentors/registered', [MentorController::class, 'registered'])->name('mentors.registered');
        // Route::get('mentors/registered/{company_id}/invite', [MentorController::class, 'invite'])->name('mentors.invite');
        Route::resource('mentors', MentorController::class);

        // Company/partner/supervisor
        // Route::get('companies/{company_id}/inviteMentors', [MentorController::class, 'invite'])->name('mentors.invite');
        // Route::post('companies/{company_id}/invite', [MentorController::class, 'sendInvite'])->name('mentors.sendinvite');
        Route::get('partners/{partner}/projects', [CompanyController::class, 'partnerProjects'])->name('partner.partnerProjects');
        Route::get('partners/{partner}/members', [CustomerController::class, 'indexPartner'])->name('partner.partnerMember');
        Route::get('partners/{partner}/members/invite', [CustomerController::class, 'invite'])->name('partner.invite');
        Route::post('partners/{partner}/members/sendInvitePartner', [CustomerController::class, 'sendInvitePartner'])->name('partner.sendInvitePartner');
        Route::resource('partners', CompanyController::class);
    });

    Route::middleware(['auth:web,company'])->group(function(){
        Route::get('/company', [DashboardController::class, 'indexCompany'])->name('company');

        // All Project Assigned
        Route::get('/all_assigned_projects',[DashboardController::class, 'allAssignedProjects'])->name('chat.allAssignedProjects');
        Route::get('/all_assigned_projects/{project}/section', [DashboardController::class, 'sectionProjectAssign'])->name('chat.section');
        Route::get('/all_assigned_projects/{project}/section/{section}/subsection', [DashboardController::class, 'subsectionProjectAssign'])->name('chat.projectSubsection');
        Route::get('/all_assigned_projects/{project}/section/{section}/chat', [DashboardController::class, 'showAllStudentsChats'])->name('chat.showAllStudentsChats');
        Route::get('/all_assigned_projects/{project}/section/{section}/student/{student}', [DashboardController::class, 'singleStudentChat'])->name('chat.singleStudentChat');
        Route::post('{mentor}/all_assigned_projects/{project}/section/{section}/student/{student}/sendComment', [CommentController::class, 'SendComment'])->name('chat.SendComment');
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
        Route::post('/projects/{project}/section/{section}/up', [ProjectController::class, 'dashboardIndexSectionUp'])->name('projects.SectionUp');
        Route::post('/projects/{project}/section/{section}/down', [ProjectController::class, 'dashboardIndexSectionDown'])->name('projects.SectionDown');

        //subsection
        Route::get('/projects/{project}/section/{section}/subsection', [ProjectController::class, 'dashboardIndexSubsection'])->name('projects.subsection');
        Route::get('/projects/{project}/section/{section}/create', [ProjectController::class, 'dashboardCreateSubsection'])->name('projects.createSubsection');
        Route::post('/projects/{project}/section/{section}', [ProjectController::class, 'dashboardStoreSubsection'])->name('projects.storeSubsection');
        Route::get('/projects/{project}/section/{section}/subsection/{subsection}/edit', [ProjectController::class, 'dashboardEditSubsection'])->name('projects.EditSubsection');
        Route::patch('/projects/{project}/section/{section}/subsection/{subsection}', [ProjectController::class, 'dashboardUpdateSubsection'])->name('projects.UpdateSubsection');
        Route::delete('/projects/{project}/section/{section}/subsection/{subsection}', [ProjectController::class, 'dashboardDestroySubsection'])->name('projects.DestroySubsection');

        // Assign Project to institution
    });
    Route::middleware(['auth:mentor'])->group(function(){
        Route::get('/mentor', [DashboardController::class, 'indexMentor'])->name('mentor');
        Route::get('/assigned_projects',[MentorController::class, 'indexAssigned'])->name('assigned.index');
        Route::get('/assigned_projects/{project}/section', [MentorController::class, 'sectionProjectAssign'])->name('assigned.projectSection');
        Route::get('/assigned_projects/{project}/section/{section}/subsection', [MentorController::class, 'subsectionProjectAssign'])->name('assigned.projectSubsection');
        Route::post('/grade/{submission}', [GradeController::class, 'subsectionProjectGradeAssign'])->name('assigned.projectSubsectionGrade');

        Route::get('/assigned_projects/{project}/section/{section}/chat', [MentorController::class, 'showAllStudentsChats'])->name('assigned.showAllStudentsChats');
        Route::get('/assigned_projects/{project}/section/{section}/student/{student}', [MentorController::class, 'singleStudentChat'])->name('assigned.singleStudentChat');
        Route::post('{mentor}/assigned_projects/{project}/section/{section}/student/{student}/sendComment', [CommentController::class, 'SendComment'])->name('assigned.SendComment');
        // Route::post('/profile/{student}/enrolled/{project}/task/{task}/chat', [CommentController::class, 'store'])->name('comment.store');

    });
});

Route::get('/testEnkripsi', [SimintEncryption::class, 'waktu']);

Route::controller(AuthOtpController::class)->group(function(){
    Route::get('/otp/login', 'login')->name('otp.login');
    // This will allow both GET and POST requests to the "otp/generate" route and prevent the "405 Method Not Allowed" error from occurring.
    // Route::match(['get', 'post'], '/otp/generate', 'generate')->name('otp.generate');
    // Route::get('/otp/generate', 'generateCheck')->name('otp.generate.check');
    Route::get('/otp/generate', 'generate')->name('otp.generate.check');
    Route::post('/otp/generate', 'generate')->name('otp.generate');
    Route::get('/otp/verification/{user_id}/{email}', 'verification')->name('otp.verification');
    Route::post('/otp/login', 'loginWithOtp')->name('otp.getlogin');
});
