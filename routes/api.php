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

Route::get('comment/{id}', [CommentController::class, 'getdatacomment'])->name('getdatacomment');
Route::get('student/project/{project}/{user}/{guard}/{institution}', [CommentController::class, 'getdatastudent'])->name('getdatastudent');
Route::get('institution/{id}', [InstitutionController::class, 'GetInstituionById'])->name('getInstitutionData');

Route::get('/dashboard/participants/{id}', function ($id) {
    $student = App\Models\Student::find($id);
    $startOfWeek = Carbon\Carbon::now()->startOfWeek();
    $endOfWeek = Carbon\Carbon::now()->endOfWeek();

    $loginCounts = App\Models\LoginLog::query()
        ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->where('student_id', $id)
        ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get()
        ->pluck('count', 'date');

    for ($date = $startOfWeek; $date->lte($endOfWeek); $date->addDay()) {
        $formattedDate = $date->format('Y-m-d');
        if (!isset($loginCounts[$formattedDate])) {
            $loginCounts[$formattedDate] = 0;
        }
    }

    $loginCounts = $loginCounts->sortKeys();

    $startOfWeek = Carbon\Carbon::now()->startOfWeek();
    $endOfWeek = Carbon\Carbon::now()->endOfWeek();

    $messageCounts = App\Models\Comment::query()
        ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->where('student_id', $id)
        ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get()
        ->pluck('count', 'date');

    for ($date = $startOfWeek; $date->lte($endOfWeek); $date->addDay()) {
        $formattedDate = $date->format('Y-m-d');
        if (!isset($messageCounts[$formattedDate])) {
            $messageCounts[$formattedDate] = 0;
        }
    }

    $messageCounts = $messageCounts->sortKeys();

    return response()->json([
        'participant' => $student,
        'track' => $student->getMentorshipTrack(),
        'loginCounts' => $loginCounts->values(),
        'loginDates' => $loginCounts->keys(),
        'messageCounts' => $messageCounts->values(),
        'messageDates' => $messageCounts->keys(),
    ]);
});

Route::post('/dashboard/participants', function (Request $request) {
    $search = $request->input('search', '');
    $mentor = $request->input('mentor', '');
    $staff = $request->input('staff', '');

    if ($search === '') {
        $students = App\Models\Student::selectRaw("id, CONCAT(first_name, ' ', last_name) AS text")
            ->where('is_confirm', 1);
    } else {
        $students = App\Models\Student::selectRaw("id, CONCAT(first_name, ' ', last_name) AS text")
            ->whereRaw("CONCAT(first_name, ' ', last_name) LIKE '%$search%'")
            ->where('is_confirm', 1);
    }
    if ($mentor) {
        $students = $students->where("mentor_id", $mentor);
    }
    if ($staff) {
        $students = $students->where("staff_id", $staff);
    }
    $response = $students->orderBy('first_name')->get()->toArray();

    return response()->json($response);
});
