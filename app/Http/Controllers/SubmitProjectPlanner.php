<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Grade;
use App\Models\Project;
use App\Models\Student;
use App\Models\NotifyMentor;
use App\Models\Submission;
use App\Models\ProjectSection;
use App\Models\EnrolledProject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubmitProjectPlanner extends Controller
{
    public function taskSubmit( Request $request,Student $student, $project_id, $task_id )
    {
        // dd($project_sections = ProjectSection::where('project_id', $project_id)->first()->assigned->first_name." ".ProjectSection::where('project_id', $project_id)->first()->assigned->last_name);
        if ($student->id != Auth::guard('student')->user()->id) {
            abort(403);
        }

        $validated = Validator::make($request->all(), [
            'glablink' => 'required',
        ]);

        if ($validated->fails()) {
            $error_message = $request->hasFile('file')
                ? 'You cannot upload a file size larger than 5MB'
                : 'No file was uploaded';

            toastr()->error($error_message);

            return redirect()
                ->route('student.taskDetail', [$student->id, $project_id, $task_id])
                ->withErrors($validated);
        }

        if ($request->dataset) {
          $dataset_array = json_decode($request->dataset, true);
          $dataset_values = array_column($dataset_array, 'value');
          $dataset_result = implode(';', $dataset_values);
        }

        $project = Project::findOrFail($project_id);
        $appliedDateStart = \Carbon\Carbon::parse(
            $project
                ->enrolled_project
                ->where('team_name', Auth::guard('student')->user()->team_name)
                ->where('project_id', $project->id)
                ->first()
                ->created_at
        )->startOfDay();
        $appliedDateEnd = \Carbon\Carbon::parse(
            $project
                ->enrolled_project
                ->where('team_name', Auth::guard('student')->user()->team_name)
                ->where('project_id', $project->id)
                ->first()
                ->created_at
        )->addMonths($project->period)->startOfDay();
        $taskDate = (new SimintEncryption())->daycompare(
            $appliedDateStart,
            $appliedDateEnd
        );

        $student = Student::where('id', Auth::guard('student')->user()->id)->first();
        $task = ProjectSection::findOrFail($task_id);
        $tiempoAdicional = ProjectSection::where('project_id', $project_id)
            ->where('id', $task_id)
            ->firstOrFail();

        $glablink = $request->input('glablink');

        // Retrieve the ProjectSection instance based on project_id and task_id
        $projectSection = ProjectSection::where('project_id', $project_id)->where('id', $task_id)->first();

        // Check if the projectSection is not null to avoid property access on null
        if ($projectSection) {
            if ($projectSection->assigned_to === null) {
                // If assigned_to is null, set studentWork to the current student's id
                $studentWork = Auth::guard('student')->user()->id;
            } else {
                // If assigned_to is not null, use the assigned_to value
                $studentWork = $projectSection->assigned_to;
            }
        } else {
            // Handle the case where the project section doesn't exist
            // You might want to throw an exception or handle this scenario appropriately
            // For now, let's assume you want to set it to null or handle it in some way
            $studentWork = null; // or handle this scenario appropriately
        }

        $submission = Submission::create([
        'section_id' => $task_id,
        'student_id' => $studentWork,
        'project_id' => $project_id,
        'is_complete' => 1,
        'flag_checkpoint' => $taskDate,
        'file' => $glablink,
        'dataset' => $request->dataset ? $dataset_result : null,
        'release_date' => Carbon::now()->format('Y-m-d'),
        'dueDate' => Carbon::now()->addDays($tiempoAdicional->duration)->format('Y-m-d'),
        'taskNumber' => $task->section,
        'type' => 'grade',
        'mentorshipType' => 'entrepreneur',
        ]);
        $submission_id = $submission->id;
        $mentorIds = [
            Auth::guard('student')->user()->mentor_id,
            Auth::guard('student')->user()->staff_id,
        ];

        foreach ($mentorIds as $mentorId) {
            // Check if the mentorId is valid before proceeding
            if ($mentorId) {
                $notifyMentor = NotifyMentor::firstOrCreate(
                    ['id_mentors' => $mentorId],
                    ['notify_mentors_data' => ['notification' => []]] // Default as an array
                );

                $notifications = $notifyMentor->notify_mentors_data; // This is automatically an array because of the $casts attribute

                // Get the last notification's idNotify and increment by 1
                $lastNotify = end($notifications['notification']);
                $nextIdNotify = $lastNotify ? $lastNotify['idNotify'] + 1 : 1;

                $newNotification = [
                    "type" => "newSubmission",
                    "isRead" => 0,
                    "idNotify" => $nextIdNotify,
                    "idStudent" => Auth::guard('student')->user()->id,
                    "studentName" => Auth::guard('student')->user()->first_name . " " . Auth::guard('student')->user()->last_name,
                    "idProject" => $project_id,
                    "projectName" => $project->name,
                    "idTask" => $task_id,
                    "taskTitle" => $task->title,
                    "idSubmission" => $submission_id, // Adjust as needed
                    "created_at" => Carbon::now()->toDateTimeString(),
                    "statusSubmission" => "new" // Adjust based on your logic
                ];

                // Append the new notification
                $notifications['notification'][] = $newNotification;

                // Save the updated notifications data back to the model
                $notifyMentor->notify_mentors_data = $notifications;
                $notifyMentor->save();
            }
        }

        return redirect('/profile/' . Auth::guard('student')->user()->id . '/enrolled/' . $project_id . '/task/' . $task_id);
    }

    public function taskResubmit(Request $request, $student_id, $project_id, $task_id, $submission_id )
    {
        if ($request->dataset) {
            $dataset_array = json_decode($request->dataset, true);
            $dataset_values = array_column($dataset_array, 'value');
            $dataset_result = implode(';', $dataset_values);
        }

        // checkpoint
        $project = Project::findOrFail($project_id);
        $appliedDateStart  = \Carbon\Carbon::parse($project->enrolled_project->where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project->id)->first()->created_at)->startOfDay();
        $appliedDateEnd  = \Carbon\Carbon::parse($project->enrolled_project->where('student_id', Auth::guard('student')->user()->id)->where('project_id', $project->id)->first()->created_at)->addMonths($project->period)->startOfDay();
        $taskDate = (new SimintEncryption)->daycompare($appliedDateStart,$appliedDateEnd);

        $student = Student::where('id', $student_id)->first();
        $dataDate = (new SimintEncryption)->daycompare($student->created_at,$student->end_date);
        $project_sections = ProjectSection::where('project_id', $project_id)->get();
        $enrolled_project_completed_or_no = EnrolledProject::where([['student_id', Auth::guard('student')->user()->id], ['project_id', $project_id]])->first()->is_submited;
        // dd($enrolled_project_completed_or_no);
        if($student_id != Auth::guard('student')->user()->id ){
            abort(403);
        }
        $task = ProjectSection::findOrFail($task_id);

        $validated = Validator::make($request->all(), [
            'glablink' => 'required',
        ]);

        $submission = Submission::findOrFail($submission_id);
        $submission->flag_checkpoint = $taskDate;
        if($request->dataset){
            $submission->dataset = $dataset_result;
        }else{
            $submission->dataset = null;
        }
        $glablink = $request->input('glablink');
        $submission->file = $glablink;
        // $submission->save();

        $grade = Grade::where('submission_id', $submission_id)->first();
        $grade->delete();

        $mentorIds = [
            Auth::guard('student')->user()->mentor_id,
            Auth::guard('student')->user()->staff_id,
        ];

        foreach ($mentorIds as $mentorId) {
            // Check if the mentorId is valid before proceeding
            if ($mentorId) {
                $notifyMentor = NotifyMentor::firstOrCreate(
                    ['id_mentors' => $mentorId],
                    ['notify_mentors_data' => ['notification' => []]] // Default as an array
                );

                $notifications = $notifyMentor->notify_mentors_data; // This is automatically an array because of the $casts attribute

                // Get the last notification's idNotify and increment by 1
                $lastNotify = end($notifications['notification']);
                $nextIdNotify = $lastNotify ? $lastNotify['idNotify'] + 1 : 1;

                $newNotification = [
                    "type" => "newSubmission",
                    "isRead" => 0,
                    "idNotify" => $nextIdNotify,
                    "idStudent" => $student_id,
                    "studentName" => Auth::guard('student')->user()->first_name . " " . Auth::guard('student')->user()->last_name,
                    "idProject" => $project_id,
                    "projectName" => $project->name,
                    "idTask" => $task_id,
                    "taskTitle" => $task->title,
                    "idSubmission" => $submission_id, // Adjust as needed
                    "created_at" => Carbon::now()->toDateTimeString(),
                    "statusSubmission" => "revision" // Adjust based on your logic
                ];

                // Append the new notification
                $notifications['notification'][] = $newNotification;

                // Save the updated notifications data back to the model
                $notifyMentor->notify_mentors_data = $notifications;
                $notifyMentor->save();
            }
        }
        return redirect('/profile/'.$student_id.'/enrolled/'.$project_id.'/task/'.$task_id);

    }
}
