<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Mentor;
use App\Models\Comment;
use App\Models\Grade;
use App\Models\Project;
use App\Models\Student;
use App\Models\Notification;
use App\Models\Submission;
use App\Models\Institution;
use Illuminate\Http\Request;
use App\Models\ProjectSection;
use App\Models\EnrolledProject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\InstitutionController;
use Illuminate\Support\Facades\Hash;

class testCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return Command::SUCCESS;
        // $newMessage = Submission::where('student_id',14)->get();
        // foreach ($newMessage as $mesd) {
        //     // print_r($mesd->grade->submission);
        //     dd($mesd->grade->readornot);

        // }
        // dd($newMessage);
        // return $notif;
        // $notifActivity = Submission::withCount('grade')->where('student_id', 14)->get();
        // $submissions = Submission::select('submissions.id as submission_id', 'students.id as student_id')
        // ->join('grades', 'submissions.id', '=', 'grades.submission_id')
        // ->join('students', 'submissions.student_id', '=', 'students.id')->where('student_id', 14)
        // ->get();
//        $encrypted = Hash::make('bayu');
//        dd($encrypted);

        // $student_id = 1;
        // $notif = Notification::get();
        // dd($notif->count());

        $notifActivity = Notification::get();
        $nop = [];
        foreach($notifActivity as $no){
            $nop[] = $no->project;
        }
        dd($nop);
        // dd(count($nop));
        // dd($notif->count() + $notifActivityCount);
    }
}
