<?php

namespace App\View\Components\Participant;

use App\Http\Controllers\SimintEncryption;
use App\Models\EnrolledProject;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\View\Component;

class ProjectTimeline extends Component
{
    public Student $participant;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Student $participant)
    {
        $this->participant = $participant;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.participant.project-timeline');
    }

    public function getStartDate()
    {
        return Carbon::parse($this->participant->created_at)->isoFormat('Do MMM, YYYY');
    }

    public function getEndDate()
    {
        return Carbon::parse($this->participant->end_date)->isoFormat('Do MMM, YYYY');
    }

    public function getTimeProgress()
    {
        $progress = SimintEncryption::daytimeline($this->participant->created_at, $this->participant->end_date);
        return $progress >= 100 ? 100 : $progress;
    }

    public function renderFlags()
    {
        $participant = $this->participant;

        $tipNumber = 1 ;
        $arr = EnrolledProject::where('is_submited', 1)->where('student_id',  $participant->id)->get();
        $html = '';

        foreach ($arr as $key => $enrolledProject) {
            $marginLeft = ($enrolledProject->flag_checkpoint >= 90 ? '90' : ($enrolledProject->flag_checkpoint - 4)) . '%';
            $content = (substr($enrolledProject->project->name, 0, 15)) . (strlen($enrolledProject->project->name) >= 15 ? '...' : '');
            $imgSrc = asset('/assets/img/icon/flag.png');
            $imgMarginLeft = ($enrolledProject->flag_checkpoint >= 90 ? '99' : $enrolledProject->flag_checkpoint) . '%';

            $html .= '<p class="absolute -top-5 font-medium text-left flex-wrap text-[10px] overflow-hidden whitespace-nowrap" style="margin-left: '. $marginLeft . '">
                        '. $content .'
                      </p>
                      <img src="'. $imgSrc .'" class="absolute top-0" style="margin-left: '. $imgMarginLeft . '">
                      ';

            $tipNumber++;
        }

        echo $html;
    }

    public function renderFlagsInfo()
    {
        $participant = $this->participant;
        $enrolledProjects = EnrolledProject::where('is_submited', 1)->where('student_id',  $participant->id)->get();

        $num = 1;
        $html = '';

        foreach ($enrolledProjects as $enrolledProject) {
            $content1 = 'Project ' . $num;
            $content2 = Carbon::parse($enrolledProject->updated_at)->isoFormat('Do MMM, YYYY');
            $marginLeft1 = ($enrolledProject->flag_checkpoint >= 90 ? (100-6) : ($enrolledProject->flag_checkpoint-2)) . '%';
            $marginLeft2 = ($enrolledProject->flag_checkpoint >= 90 ? (99-4) : ($enrolledProject->flag_checkpoint-2)) . '%';
            $marginLeft = $marginLeft1 > $marginLeft2 ? $marginLeft1 : $marginLeft2;

            $html .= '<div class="absolute mt-2 font-medium text-center text-[10px]" style="margin-left: '. $marginLeft . '">
                            <p class="font-semibold">
                                '. $content1 .'
                            </p>
                            <p>
                                '. $content2 .'
                            </p>
                        </div>
                     ';

            $num++;
        }

        echo $html;
    }
}
