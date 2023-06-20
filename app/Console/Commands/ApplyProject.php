<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use App\Models\EnrolledProject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ApplyProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:apply {student_id} {project_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Apply a student to a project';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $student_id = $this->argument('student_id');
        $project_id = $this->argument('project_id');
        $project = Project::find($project_id);
        
        $student = Auth::guard('student')->loginUsingId($student_id);

        $now_time = Carbon::now();
        $intern_end = Carbon::parse($student->end_date);
        $remaining_intern_days = $now_time->diffInDays($intern_end,false);

        $project_time = $now_time->addMonth($project->period);
        $project_totaldays = Carbon::now()->diffInDays($project_time);

        $enrolled_project = new EnrolledProject;
        $already_enrolled =  EnrolledProject::where('student_id', $student_id)
                                            ->where('is_submited', 0)->latest()->first();

        $total_month_complete = Project::select('period')->whereHas('enrolled_project', function($q) use ($student_id){
            $q->where('student_id', $student_id);
            $q->where('is_submited',1);
        })->count();

        if($total_month_complete < 3){
            if($remaining_intern_days - $project_totaldays >= 30){
                if($already_enrolled == null ){
                    $enrolled_project->student_id = $student_id;
                    $enrolled_project->project_id = $project_id;
                    $enrolled_project->is_submited = 0;
                    $enrolled_project->save();
                    $this->info('Selected project has been applied');
                }else{
                    $this->error('Kindly complete your ongoing project');
                }
            }
            else{
                $this->error('Your available intern time is not sufficient');
            }
        }else{
            $this->error('Your completed projects already 3 months long, please prepare for final submission');
        }
    }
}
