<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PdfController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\StaffController;
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
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FaceDetectionController;
use App\Http\Controllers\EnrolledProjectController;
use App\Http\Controllers\EmailBulkInvitationController;
use App\Http\Controllers\SubmitProjectPlanner;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\InternalDocumentController;
use App\Http\Controllers\NotificationAndMessageController;

// use App\Http\Controllers\ChatbotController;

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
// Route::post('/ask', [ChatbotController::class, 'ask']);
// Experimental
// Route::get('/newindex', [IndexController::class, 'newindex'])->name('newindex');
Route::get('/face-detection', [FaceDetectionController::class, 'index']);
Route::get('/run-face-detection', [FaceDetectionController::class, 'runFaceDetection']);

Route::get('/cleaned_comments', [App\Http\Controllers\CleanedCommentController::class, 'getCleanedComments'])->middleware('auth:web');

// Experimental
Route::get('/theplayground', function () {
    return view('experiment.index');
})->middleware('auth:web')->name('theplayground');

//Static Page
Route::get('/emailtemp', function () {
    return view('emails.contactUs');
})->name('emailtemp');
Route::get('/supportlib', function () {
    return view('projects.supportlibrary');
})->name('projects.support');
Route::get('/faq', [FAQController::class, 'index'])->name('faq');
Route::get('/contact', [DashboardController::class, 'contact'])->name('contact');
Route::post('/contact', [DashboardController::class, 'sendContact'])->name('sendContact');
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

// Track Info
Route::view('/track-info/skills-track', 'skills-track-info')->name('track-info.skills-track');
Route::view('/track-info/entrepreneur-track', 'entrepreneur-track-info')->name('track-info.entrepreneur-track');

// Internal Document
Route::get('/internal-document', [InternalDocumentController::class, 'index'])->name('internal-document-menu');
Route::get('/internal-document/{slug}', [InternalDocumentController::class, 'viewPublicPage'])->name('internal-document');

// for debugging temp
// Route::get('/ccc/{student}/{project}', [ProjectController::class, 'appliedDetail'])->name('ccc');
// Route::get('/viewbulk', [EmailBulkInvitationController::class, 'index'])->name('view.bulk.email');
// Route::post('emailsbulk', [EmailBulkInvitationController::class, 'upload'])->name('bulk.upload.email');

// register
Route::get('/verify/{email}', [AuthController::class, 'verifyEmail'])->name('verify');
Route::get('/verified/{email}', [AuthController::class, 'verified'])->name('verified');
Route::get('/register', [AuthController::class, 'register'])->name('registerPage');
Route::post('/register', [AuthController::class, 'store'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/login', [AuthController::class, 'multiLogIn'])->name('multiLogIn');
Route::post('/login/auth', [AuthController::class, 'multiLogInCheck'])->name('multiLogInCheck');
Route::get('/sendmail', [MailController::class, 'index']);
Route::get('/Vv2g5bdRc0bqs5fOB6Nj0emOd9B7bobU8MaJKWb2MMCJMJaZL3CtW', [AuthController::class, 'login'])->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
// forgot password
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
Route::post('/forgot-password', [AuthController::class, 'submitForgotPassword'])->name('submitForgotPassword');
Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('showResetForm');
Route::post('/password/reset/', [AuthController::class, 'resetPassword'])->name('resetPassword');


// mentor register
Route::get('/register/supervisor/{email}', [MentorController::class, 'register'])->name('supervisor.register');
Route::post('/register/supervisor/{email}', [MentorController::class, 'update'])->name('supervisor.registerAuth');

// student register - bayu - there's 2 route for now 09/02/2023
Route::get('/register/student/{email}', [StudentController::class, 'register'])->name('student.register');
Route::post('/register/student/{email}', [StudentController::class, 'completedRegister'])->name('student.register.completed');

// customer register - bayu - there's 2 route for now 09/02/2023
Route::get('/register/customer/{email}', [CustomerController::class, 'register'])->name('customer.register');
Route::post('/register/customer/{email}', [CustomerController::class, 'completedRegister'])->name('customer.register.completed');

// Route::post('/register/student/{email}/auth', [StudentController::class, 'update'])->name('student.registerAuth');


// bay
Route::group(['middleware'=>'auth:student'], function(){
    // Notification and Message Handler for Students
    Route::post('/notifications/mark-as-read/{idNotify}', [NotificationAndMessageController::class, 'markAsRead'])->name('notifications.students.markAsRead');
    // End Notification and Message Handler for Students

    // Project Planner submit and resubmit
    Route::post('/project/{student}/enrolled/{project}/task/{task}', [SubmitProjectPlanner::class, 'taskSubmit'])->name('student.projectPlanner.taskSubmit');
    Route::patch('/project/{student}/enrolled/{project}/task/{task}/submission/{submission}', [StudentController::class, 'taskResubmit'])->name('student.projectPlanner.taskResubmit');
    // End

    Route::post('/feedback/{student}', [StudentController::class, 'feedbackStudent'])->name('student.feedback');
    Route::get('/profile/{student}/allProjects', [StudentController::class, 'allProjects'])->name('student.allProjects');
    Route::get('/profile/{student}/allProjectsAvailable', [StudentController::class, 'allProjectsAvailable'])->name('student.allProjectsAvailable');
    Route::get('/profile/{student}/ongoingProjects', [StudentController::class, 'ongoingProjects'])->name('student.ongoingProjects');
    Route::get('/profile/{student}/completedProjects', [StudentController::class, 'completedProjects'])->name('student.completedProjects');
    Route::get('/profile/{student}/enrolled/{project}/detail', [StudentController::class, 'enrolledDetail'])->name('student.enrolledDetail');
    Route::get('/profile/{student}/enrolled/{project}/task/{task}', [StudentController::class, 'taskDetail'])->name('student.taskDetail');
    Route::post('/profile/{student}/enrolled/{project}/task/{task}/id/{id}', [StudentController::class, 'taskSubmit'])->name('student.taskSubmit');
    Route::patch('/profile/{student}/enrolled/{project}/task/{task}/submission/{submission}', [StudentController::class, 'taskResubmit'])->name('student.taskResubmit');
    Route::get('/profile/{student}/enrolled/{project}/task/{task}/readComment/{id}', [StudentController::class, 'readComment'])->name('student.readComment');
    Route::get('/profile/{student}/enrolled/{project}/task/{task}/readNotif/{id}', [StudentController::class, 'readActivity'])->name('student.readActivity');
    Route::get('/profile/{student}/project/{project}/notification/{notification}/readNotifTask/', [StudentController::class, 'readActivityTask'])->name('student.readActivityTask');

    // Chat with Team
    Route::get('/profile/{student}/chat', [StudentController::class, 'chat'])->name('student.chat');

    // Support
    Route::get('/profile/{student}/support', [StudentController::class, 'support'])->name('student.support');
    Route::post('/profile/{student}/support', [StudentController::class, 'sendSupport'])->name('student.sendSupport');



    Route::get('/profile/{student}/allProjectsAvailable/{project}/detail', [StudentController::class, 'availableProjectDetail'])->name('student.availableProjectDetail');
    // Route::get('/projects/{student}/applied/{project}/detail', [ProjectController::class, 'appliedDetail'])->name('projects.appliedDetail');
    Route::post('/profile/{student}/enrolled/{project}/task/{task}/chat', [CommentController::class, 'store'])->name('comment.store');

    Route::get('/profile/{student}/edit', [StudentController::class, 'edit'])->name('student.edit');
    Route::patch('/profile/{student}', [StudentController::class, 'update'])->name('student.update');

    // Switch Project
    Route::patch('/profile/{student}/switch', [StudentController::class, 'updateSwitch'])->name('student.switch.update');

    // Bell Notification
    // /profile/{{$student->id}}/all-notification
    Route::get('/profile/{student}/allNotification', [NotificationController::class, 'index'])->name('student.allNotification');
    Route::get('/profile/{student}/{institution}/certificate', [StudentController::class, 'certificate'])->name('student.certificate');
    Route::get('/profile/{student}/generate', [PdfController::class, 'downloadPDF'])->name('download-pdf');
    // Route::get('/download-pdf', [PdfController::class, 'downloadPDF'])->name('download-pdf');
    // Certificate
});
// Student projects page
// Route::group(['middleware'=>'auth:student'], function(){
    // projects page
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/search', [ProjectController::class, 'search'])->name('projects.search');

Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show')->middleware('auth:student,web,customer,mentor');
Route::get('/projects/{project}/detail/{subsection}',[ProjectController::class, 'showSubsection'])->name('projects.subsection');
// Route::get('/projects/{student}/applied', [ProjectController::class, 'applied'])->name('projects.applied');
// Route::get('/projects/{student}/applied/{project}/detail', [ProjectController::class, 'appliedDetail'])->name('projects.appliedDetail');
Route::get('/projects/{student}/applied/{project}/task/{section}/detail/{subsection}/submission', [ProjectController::class, 'appliedSubmission'])->name('projects.appliedSubmission');
Route::post('/projects/{student}/applied/{project}/detail/{subsection}', [ProjectController::class, 'appliedSubmit'])->name('projects.appliedSubmit');
Route::group(['middleware'=>'auth:student'], function(){
    Route::post('/projects/{project}/apply', [ProjectController::class, 'applyProject'])->name('projects.apply');
});

Route::get('/theworld', [TheWorldController::class, 'index']);

// Homepage
Route::get('/students-info', [HomepageController::class, 'studentsInfo'])->name('students.info');
Route::get('/institutes-info', [HomepageController::class, 'institutesInfo'])->name('institutes.info');
Route::get('/partners-info', [HomepageController::class, 'partnersInfo'])->name('partners.info');

Route::group(['prefix'=>'dashboard','as'=>'dashboard.'], function(){
    // dashboard page

    Route::middleware(['auth:web'])->group(function(){
        Route::get('/admin', [DashboardController::class, 'index'])->name('admin');
        // Student in institutions
        Route::get('/institutions/{institution}/students/{student}/manage', [StudentController::class, 'manage' ])->name('students.manage');
        Route::patch('/institutions/{institution}/students/{student}/managepatch', [StudentController::class, 'managepatch' ])->name('students.managepatch');
        Route::post('/institutions/{institution}/students/{student}/suspend', [StudentController::class, 'suspendAccountInstitution' ])->name('students.suspendAccountInstitution');

        Route::get('/students/{student}/manage', [StudentController::class, 'manageStudent'])->name('students.manageStudent');
        Route::patch('/students/{student}/managepatch', [StudentController::class, 'manageStudentpatch' ])->name('students.manageStudentpatch');
        Route::post('/students/{student}/suspend', [StudentController::class, 'suspendAccount' ])->name('students.suspendAccount');

        // Staff
        Route::get('/staffs', [StaffController::class, 'index'])->name('staffs.index');
        Route::get('/staffs/invite', [StaffController::class, 'invite'])->name('staffs.invite');
        Route::post('/staffs/sendInvite', [StaffController::class, 'sendInvite'])->name('staffs.sendInvite');
        Route::get('/staffs/{staff}/edit', [StaffController::class, 'edit'])->name('staffs.edit');
        Route::patch('/staffs/{staff}/update', [StaffController::class, 'update' ])->name('staffs.update');
        Route::get('/staffs/{staff}/suspend', [StaffController::class, 'suspend' ])->name('staffs.suspend');
        Route::delete('/staffs/{staff}', [StaffController::class, 'destroy'])->name('staffs.destroy');
        Route::get('/staffs/{staff}/participants', [StaffController::class, 'participants'])->name('staffs.participants');

        // Internal Document
        Route::get('/internal-document/all-pages', [InternalDocumentController::class, 'allPages'])->name('internal-document.all-pages.index');
        Route::get('/internal-document/all-pages/view/{id}', [InternalDocumentController::class, 'viewPage'])->name('internal-document.all-pages.view');
        Route::get('/internal-document/all-pages/add', [InternalDocumentController::class, 'addPage'])->name('internal-document.all-pages.add');
        Route::post('/internal-document/all-pages/add', [InternalDocumentController::class, 'savePage'])->name('internal-document.all-pages.save');
        Route::get('/internal-document/all-pages/edit/{id}', [InternalDocumentController::class, 'editPage'])->name('internal-document.all-pages.edit');
        Route::put('/internal-document/all-pages/edit/{id}', [InternalDocumentController::class, 'updatePage'])->name('internal-document.all-pages.update');
        Route::get('/internal-document/all-pages/delete-file/{id}', [InternalDocumentController::class, 'deletePageFile'])->name('internal-document.all-pages.delete-file');
        Route::get('/internal-document/group-section', [InternalDocumentController::class, 'groupSection'])->name('internal-document.group-section.index');

        // Institution
        // Route::post('institutions/{institution}/edit/confirm', [InstitutionController::class, 'update'])->name('institutions.update.confirm');
        // Route::patch('institutions/{institution}', [InstitutionController::class, 'update'])->name('institutions.update');
        Route::get('/institutions_partners', [InstitutionController::class, 'institutions_partners'])->name('institutions_partners');
        Route::get('/institutions/{institution}/students', [InstitutionController::class, 'institutionStudents'])->name('students.institutionStudents');

        Route::get('/institutions/{institution}/students/invite', [StudentController::class, 'inviteFromInstitution'])->name('students.inviteFromInstitution');
        Route::post('/institutions/{institution}/students', [StudentController::class, 'sendInviteFromInstitution'])->name('students.sendInviteFromInstitution');

        // Route::post('/institutions/students', [StudentController::class, 'sendInvite'])->name('students.sendInvite');

        Route::get('/institutions/{institution}/supervisors', [MentorController::class, 'index'])->name('institutionSupervisors');
        Route::get('/institutions/{institution}/supervisors/invite', [MentorController::class, 'invite'])->name('institutionSupervisorInvite');
        Route::post('/institutions/{institution}/supervisors', [MentorController::class, 'sendInvite'])->name('mentors.institutionSupervisorSendInvite');
        Route::get('/institutions/{institution}/supervisors/{supervisor}/edit', [MentorController::class, 'edit'])->name('mentors.institutionSupervisorEdit');
        Route::patch('/institutions/{institution}/supervisors/{supervisor}', [MentorController::class, 'updateMentorDashboard'])->name('mentors.institutionSupervisorUpdate');
        Route::get('/institutions/{institution}/supervisors/{supervisor}/suspend', [MentorController::class, 'suspendSupervisorDashboard'])->name('mentors.suspendSupervisorDashboard');
        Route::delete('/institutions/{institution}/supervisors/{supervisor}', [MentorController::class, 'destroy'])->name('mentors.deleteSupervisor');


        Route::post('/institutions/{institution}/suspend', [InstitutionController::class, 'suspendInstitution'])->name('institutions.suspend');
        Route::resource('institutions', InstitutionController::class);

        // Mentors
        Route::get('/mentors/registered', [MentorController::class, 'registered'])->name('mentors.registered');
        // Route::get('mentors/registered/{company_id}/invite', [MentorController::class, 'invite'])->name('mentors.invite');
        Route::resource('mentors', MentorController::class);

        // Company/partner/supervisor
        // Route::get('companies/{company_id}/inviteMentors', [MentorController::class, 'invite'])->name('mentors.invite');
        // Route::post('companies/{company_id}/invite', [MentorController::class, 'sendInvite'])->name('mentors.sendinvite');

        // ==============PARTNER CREATE PROJECT=========
        Route::get('/partners/{partner}/projects', [ProjectController::class, 'partnerProjects'])->name('partner.partnerProjects');
        Route::get('/partners/{partner}/projects/create', [ProjectController::class, 'partnerProjectsCreate'])->name('partner.partnerProjectsCreate');
        Route::post('/partners/{partner}/projects', [ProjectController::class, 'partnerProjectsStore'])->name('partner.partnerProjectsStore');
        Route::post('/partners/{partner}/projects/{project}', [ProjectController::class, 'partnerProjectsInjectionStore'])->name('partner.partnerProjectsInjectionStore');
        Route::patch('/partners/{partner}/projects/{project}', [ProjectController::class, 'partnerProjectsUpdate'])->name('partner.partnerProjectsUpdate');
        Route::patch('/partners/{partner}/projects/{project}/publishDraft', [ProjectController::class, 'publishDraft'])->name('partner.partnerProjectspublishDraft');
        Route::delete('/partners/{partner}/projects/{project}', [ProjectController::class, 'destroy'])->name('partner.partnerProjectsDestroy');
        Route::get('/partners/{partner}/projects/{project}/edit', [ProjectController::class, 'partnerProjectsEdit'])->name('partner.partnerProjectsEdit');

        Route::get('/partners/{partner}/projects/{project}/injection', [ProjectController::class, 'partnerProjectsInjection'])->name('partner.partnerProjectsInjection');
                    // /partners/{{$partner->id}}/project/{{$project->id}}/injection/{{$card->id}}/edit
        Route::get('/partners/{partner}/projects/{project}/injection/{injection}/edit',[ProjectController::class, 'partnerProjectsInjectionEdit'])->name('partner.partnerProjectsInjectionEdit');
        Route::patch('/partners/{partner}/projects/{project}/injection/{injection}',[ProjectController::class, 'partnerProjectsInjectionUpdate'])->name('partner.partnerProjectsInjectionUpdate');
        Route::get('/partners/{partner}/projects/{project}/injection/{injection}/delete',[ProjectController::class, 'partnerProjectsInjectionDelete'])->name('partner.partnerProjectsInjectionDelete');


        // =======Partner create project injection card attachment
        Route::get('/partners/{partner}/projects/{project}/injection/{injection}/attachment', [ProjectController::class, 'partnerProjectsInjectionAttachment'])->name('partner.partnerProjectsInjectionAttachment');
        Route::get('/partners/{partner}/projects/{project}/injection/{injection}/attachment/{attachment}/edit', [ProjectController::class, 'partnerProjectsInjectionAttachmentEdit'])->name('partner.partnerProjectsInjectionAttachmentEdit');
        Route::patch('/partners/{partner}/projects/{project}/injection/{injection}/attachment/{attachment}', [ProjectController::class, 'partnerProjectsInjectionAttachmentUpdate'])->name('partner.partnerProjectsInjectionAttachmentUpdate');
        Route::get('/partners/{partner}/projects/{project}/injection/{injection}/attachment/{attachment}/delete/{key}', [ProjectController::class, 'partnerProjectsInjectionAttachmentDelete'])->name('partner.partnerProjectsInjectionAttachmentDelete');
        Route::post('/partners/{partner}/projects/{project}/injection/{injection}/attachment', [ProjectController::class, 'partnerProjectsInjectionAttachmentStore'])->name('partner.partnerProjectsInjectionAttachmentStore');

        // Partner edit member

        // Customer
        Route::get('partners/{partner}/members', [CustomerController::class, 'indexPartner'])->name('partner.partnerMember');
        Route::get('/partners/{partner}/members/{member}/edit', [CustomerController::class, 'partnerMemberEdit'])->name('partner.partnerMemberEdit');
        Route::patch('/partners/{partner}/members/{member}', [CustomerController::class, 'partnerMemberUpdate'])->name('partner.partnerMemberUpdate');
        Route::get('partners/{partner}/members/invite', [CustomerController::class, 'invite'])->name('partner.invite');
        // /dashboard/partners/{{$partner->id}}/members/{{$member->id}}/suspend
        Route::get('/partners/{partner}/members/{member}/suspend', [CustomerController::class, 'partnerMemberSuspend'])->name('mentors.partnerMemberSuspend');
        Route::delete('/partners/{partner}/members/{member}', [CustomerController::class, 'destroy'])->name('mentors.partnerMemberDelete');

        Route::post('partners/{partner}/members/sendInvitePartner', [CustomerController::class, 'sendInvitePartner'])->name('partner.sendInvitePartner');
        Route::resource('partners', CompanyController::class);

        // Certificate
        Route::get('/certificate', [CertificateController::class, 'index'])->name('certificate.index');
        Route::get('/certificate/add/{student}', [CertificateController::class, 'edit'])->name('certificate.edit');
        Route::patch('/certificate/add/{student}', [CertificateController::class, 'update'])->name('certificate.update');
    });

    Route::middleware(['auth:web,customer,mentor'])->group(function(){
        Route::post('/notifications/mark-as-read/mentor/{idNotify}', [NotificationAndMessageController::class, 'markAsReadMentor'])->name('notifications.mentor.markAsRead');
        Route::get('/company', [DashboardController::class, 'indexCompany'])->name('company');

        // All Project Assigned
        Route::get('/all_assigned_projects',[DashboardController::class, 'allAssignedProjects'])->name('chat.allAssignedProjects');
        Route::get('/all_assigned_projects/{project}/section', [DashboardController::class, 'sectionProjectAssign'])->name('chat.section');
        Route::get('/all_assigned_projects/{project}/section/{section}/subsection', [DashboardController::class, 'subsectionProjectAssign'])->name('chat.projectSubsection');
        Route::get('/all_assigned_projects/{project}/section/{section}/chat', [DashboardController::class, 'showAllStudentsChats'])->name('chat.showAllStudentsChats');
        Route::get('/all_assigned_projects/{project}/section/{section}/submission', [DashboardController::class, 'showAllStudentsSubmission'])->name('chat.showAllStudentsSubmission');
        Route::get('/all_assigned_projects/{project}/section/{section}/student/{student}', [DashboardController::class, 'singleStudentChat'])->name('chat.singleStudentChat');
        // Route::post('{mentor}/all_assigned_projects/{project}/section/{section}/student/{student}/sendComment', [CommentController::class, 'SendComment'])->name('chat.SendComment');

        // Project
        Route::get('/projects', [ProjectController::class, 'dashboardIndex'])->name('projects.index');
        Route::get('/projects/draft', [ProjectController::class, 'draftIndex'])->name('projects.draft');
        Route::get('/projects/create', [ProjectController::class, 'dashboardIndexCreate'])->name('projects.create');
        Route::post('/projects', [ProjectController::class, 'dashboardIndexStore'])->name('projects.store');
        Route::get('/projects/{project}/edit', [ProjectController::class, 'dashboardIndexEdit'])->name('projects.edit');
        Route::get('/projects/{project}/show', [ProjectController::class, 'dashboardIndexShow'])->name('projects.show');
        Route::patch('/projects/{project}', [ProjectController::class, 'dashboardIndexUpdate'])->name('projects.update');
        // Add this route for image upload
        Route::post('/project/image-upload', [ProjectController::class, 'store'])->name('project.image-upload');
        // Route::patch('projects/{project}/publish', [ProjectController::class, 'dashboardpublish'])->name('project.publish');
        Route::patch('/projects/{project}/publishDraft', [ProjectController::class, 'dashboardpublishDraft'])->name('projects.publishDraft');

        Route::delete('/projects/{project}', [ProjectController::class, 'dashboardIndexDestroy'])->name('projects.destroy');

        //section
        Route::get('/projects/{project}/injection', [ProjectController::class, 'dashboardIndexSection'])->name('projects.section');
        Route::post('/projects/{project}', [ProjectController::class, 'dashboardIndexStoreSection'])->name('projects.storeSection');
        Route::get('/projects/{project}/injection/{injection}/edit', [ProjectController::class, 'dashboardIndexEditSection'])->name('projects.EditSection');
        Route::get('/projects/{project}/injection/{injection}/show', [ProjectController::class, 'dashboardIndexShowSection'])->name('projects.ShowSection');
        Route::patch('/projects/{project}/injection/{injection}', [ProjectController::class, 'dashboardIndexUpdateSection'])->name('projects.UpdateSection');
        Route::get('/projects/{project}/injection/{injection}/delete', [ProjectController::class, 'dashboardIndexDestroySection'])->name('projects.DestroySection');

        //subsection
        Route::get('/projects/{project}/injection/{injection}/attachment', [ProjectController::class, 'dashboardIndexSubsection'])->name('projects.subsection');
        Route::post('/projects/{project}/injection/{injection}/attachment', [ProjectController::class, 'dashboardStoreSubsection'])->name('partner.storeSubsection');
        Route::get('/projects/{project}/injection/{injection}/attachment/{attachment}/delete/{key}', [ProjectController::class, 'dashboardDestroySubsection'])->name('partner.DestroySubsection');
        Route::get('/projects/{project}/injection/{injection}/attachment/{attachment}/edit', [ProjectController::class, 'dashboardEditSubsection'])->name('partner.EditSubsection');
        Route::patch('/projects/{project}/injection/{injection}/attachment/{attachment}', [ProjectController::class, 'dashboardUpdateSubsection'])->name('partner.UpdateSubsection');

        // Submission
        Route::get('/submissions/project/{project}', [SubmissionController::class, 'show'])->name('submission.show');
        Route::get('/submissions/project/{project}/view/{submission}', [SubmissionController::class, 'singleSubmission'])->name('submission.singleSubmission');
        Route::get('/submissions/project/{project}/view/{submission}/readNotification/{student}', [DashboardController::class, 'singleSubmissionReadNotification'])->name('submission.singleSubmission.readNotification');
        Route::post('/submissions/project/{project}/view/{submission}/adminGrade', [SubmissionController::class, 'adminGrade'])->name('submission.adminGrade');
        Route::get('/submissions/project/{project}/view/{submission}/grade/{grade}', [SubmissionController::class, 'edit'])->name('submission.editSubmissionGrade');
        Route::post('/submissions/project/{project}/view/{submission}/grade/changeGrade', [SubmissionController::class, 'changeGrade'])->name('submission.changeGrade');

        // Enrollment
        Route::get('/enrollment/project/{id}', [EnrolledProjectController::class, 'show'])->name('enrollment.show');
        Route::post('/enrollment/project/{id}/{student}/{project}', [EnrolledProjectController::class, 'edit'])->name('enrollment.edit');

        // Notification
        Route::view('/notifications', 'dashboard.notifications.index')->name('notifications.index');

        // Message
        Route::get('/messages', [CommentController::class, 'index'])->name('messages.index');
        Route::get('/messages/create', [CommentController::class, 'create'])->name('messages.create');
        Route::get('/messages/{injection}', [CommentController::class, 'taskMessage'])->name('messages.taskMessage');
        Route::get('/messages/{injection}/single/{participant}', [CommentController::class, 'single'])->name('messages.single');
        Route::get('/messages/{injection}/reply/{participant}', [CommentController::class, 'adminReply'])->name('messages.adminReply');
        // Route::get('/messages/{injection}/reply/{participant}', [CommentController::class, 'adminReply'])->name('messages.adminReply');
        Route::post('/messages/{injection}/reply/{participant}/sendMessage', [CommentController::class, 'adminSendMessage'])->name('messages.adminSendMessage');
        Route::post('/messages', [CommentController::class, 'adminSendMessageGlobal'])->name('messages.adminSendMessageGlobal');

        // Profile
        Route::get('/profile/{profile}/edit', [DashboardController::class, 'profile'])->name('profile.edit');
        Route::patch('/profile/{profile}/', [DashboardController::class, 'updateProfile'])->name('profile.update');

        // Student
        Route::get('/students/invite', [StudentController::class, 'inviteFromInstitution' ])->name('students.invite');
        Route::resource('students', StudentController::class);
        Route::post('/students/invite', [StudentController::class, 'sendInvite'])->name('students.sendInviteStudent');
        Route::get('/testimonial', [StudentController::class, 'testimonial'])->name('testimonial');
    });
    Route::middleware(['auth:web,mentor'])->group(function(){
        Route::get('/mentor', [DashboardController::class, 'indexMentor'])->name('mentor');
        Route::get('/completed_all', [DashboardController::class, 'studentCompleteAll'])->name('student.completeAll');
        Route::get('/completed_all/{student}', [DashboardController::class, 'studentCompleteAssign'])->name('student.studentCompleteAssign');
        Route::post('/completed_all/{student}', [DashboardController::class, 'studentCompleteAssignStore'])->name('student.studentCompleteAssignStore');
        Route::get('/completed_3', [DashboardController::class, 'studentComplete3'])->name('student.complete3');
        Route::get('/final-presentation-ongoing', [DashboardController::class, 'finalPresentationOngoing'])->name('student.finalPresentationOngoing');
        Route::get('/final-presentation-complete', [DashboardController::class, 'finalPresentationComplete'])->name('student.finalPresentationComplete');

        Route::get("/chat", [DashboardController::class, 'chat'])->name('chat');

        // Route::get('/students/invite', [StudentController::class, 'inviteFromInstitution' ])->name('students.invite');
        // Route::post('/students/invite', [StudentController::class, 'sendInvite'])->name('students.sendInviteStudent');

        // Route::get('/students/{student}/manage', [StudentController::class, 'manageStudent'])->name('students.manageStudent');
        // Route::resource('students', StudentController::class);
        // Route::patch('/students/{student}/managepatch', [StudentController::class, 'manageStudentpatch' ])->name('students.manageStudentpatch');

        Route::get('/assigned_projects',[MentorController::class, 'indexAssigned'])->name('assigned.index');
        Route::get('/assigned_projects/{project}/section', [MentorController::class, 'sectionProjectAssign'])->name('assigned.projectSection');
        Route::get('/assigned_projects/{project}/section/{section}/subsection', [MentorController::class, 'subsectionProjectAssign'])->name('assigned.projectSubsection');
        Route::post('/grade/{submission}', [GradeController::class, 'subsectionProjectGradeAssign'])->name('assigned.projectSubsectionGrade');

        Route::get('/assigned_projects/{project}/section/{section}/chat', [MentorController::class, 'showAllStudentsChats'])->name('assigned.showAllStudentsChats');
        Route::get('/assigned_projects/{project}/section/{section}/student/{student}', [MentorController::class, 'singleStudentChat'])->name('assigned.singleStudentChat');

        Route::post('{mentor}/assigned_projects/{project}/section/{section}/student/{student}/sendComment', [CommentController::class, 'SendComment'])->name('assigned.SendComment');
        Route::post('/profile/{student}/enrolled/{project}/task/{task}/chat', [CommentController::class, 'store'])->name('comment.store');

    });

    Route::middleware(['auth:web,customer'])->group(function(){
        Route::get('/customer', [DashboardController::class, 'indexCustomer'])->name('customer');
        Route::get('/customers', [DashboardController::class, 'allCustomer'])->name('customers.index');
        Route::get('/customers/{member}/edit', [DashboardController::class, 'allCustomerEdit'])->name('customers.allCustomerEdit');
        Route::get('/customers/invite', [CustomerController::class, 'invite'])->name('customers.invite');
        Route::post('/customer/sendInvitePartner/{partner}', [CustomerController::class, 'sendInvitePartner'])->name('customers.sendInvitePartner');


    });
});

// Route::get('/testEnkripsi', [SimintEncryption::class, 'waktu']);

// Route::controller(AuthOtpController::class)->group(function(){
//     Route::get('/otp/login', 'login')->name('otp.login');
//     Route::get('/otp/generate', 'generate')->name('otp.generate.check');
//     Route::post('/otp/generate', 'generate')->name('otp.generate');
//     Route::get('/otp/verification/{user_id}/{email}', 'verification')->name('otp.verification');
//     Route::post('/otp/login', 'loginWithOtp')->name('otp.getlogin');
// });
Route::fallback(function() {
  abort(404);
});
