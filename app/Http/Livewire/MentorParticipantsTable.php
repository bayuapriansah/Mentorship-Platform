<?php

namespace App\Http\Livewire;

use App\Http\Controllers\SimintEncryption;
use App\Models\EnrolledProject;
use App\Models\Mentor;
use App\Models\Student;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Nnjeim\World\Models\Country;

class MentorParticipantsTable extends Component
{
    use WithPagination;

    public Mentor $mentor;
    public $countries;
    public $enrolledProjects;

    public $limit = 10;
    public $search = '';
    public $sortField = 'first_name';
    public $sortDirection = 'asc';
    public $filterByMentorshipType = '';
    public $filterByCountry = '';

    public $sortOptions = [
        'first_name' => 'Participant Name',
        // 'mentor.name' => 'Mentor Name',
        'staff.name' => 'Staff Name',
        'country' => 'Country',
        'team_name' => 'Team Name',
    ];

    public function render()
    {
        return view('livewire.mentor-participants-table', [
            'participants' => $this->getParticipants(),
        ]);
    }

    public function mount(Mentor $mentor)
    {
        $this->mentor = $mentor;
        $this->countries = Country::orderBy('name')->get();
        $this->enrolledProjects = EnrolledProject::all();
    }

    public function paginationView()
    {
        return 'livewire._participants-table-pagination';
    }

    private function getParticipants()
    {
        $query = Student::query()
                    ->with('mentor','staff')
                    ->where('is_confirm', true);

        if ($this->mentor->institution_id === 0) {
            $query = $query->where('staff_id', $this->mentor->id);
        } else {
            $query = $query->where('mentor_id', $this->mentor->id);
        }

        if (!empty(trim($this->search))) {
            $search = '%'. $this->search. '%';
            $query = $query->whereRaw("CONCAT(first_name,' ', last_name) like?", [$search])
                        ->orWhereHas('mentor', function ($query) use ($search) {
                            $query->whereRaw("CONCAT(first_name,' ', last_name) like?", [$search]);
                        })
                        ->orWhereHas('staff', function ($query) use ($search) {
                            $query->whereRaw("CONCAT(first_name,' ', last_name) like?", [$search]);
                        })
                        ->orWhere('country', 'like', $search)
                        ->orWhere('team_name', 'like', $search)
                        ->orWhere('mentorship_type', 'like', $search);
        }

        if (!empty($this->filterByMentorshipType)) {
            $query = $query->where('mentorship_type', $this->filterByMentorshipType);
        }

        if (!empty($this->filterByCountry)) {
            $query = $query->where('country', $this->filterByCountry);
        }

        $query = $this->sortData($query);

        return $query->paginate($this->limit);
    }

    public function sortData($query)
    {
        switch ($this->sortField) {
            case 'mentor.name':
                return $query->orderBy(
                    Mentor::select('first_name')->whereColumn('id', 'students.mentor_id'),
                    $this->sortDirection
                );

            case 'staff.name':
                return $query->orderBy(
                    Mentor::select('first_name')->whereColumn('id', 'students.staff_id'),
                    $this->sortDirection
                );

            default:
                return $query->orderBy($this->sortField, $this->sortDirection);
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetSearch()
    {
        $this->search = '';
    }

    public function resetAllFilters()
    {
        $this->filterByMentorshipType = '';
        $this->filterByCountry = '';
    }

    public function getDataDate(Student $participant)
    {
        $dataDate = SimintEncryption::daytimeline($participant->created_at, $participant->end_date);

        return $dataDate >= 100 ? 100 : $dataDate;
    }

    public function getDataFlag(Student $participant)
    {
        $tipNumber = 1 ;
        $arr = $this->enrolledProjects->where('is_submited', 1)->where('student_id',  $participant->id);
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

    public function getDataInfo(Student $participant)
    {
        $num = 1;
        $html = '';

        foreach ($this->enrolledProjects->where('is_submited', 1)->where('student_id',  $participant->id) as $enrolledProject) {
            $marginLeft1 = ($enrolledProject->flag_checkpoint >= 90 ? (100-6) : ($enrolledProject->flag_checkpoint-2)) . '%';
            $marginLeft2 = ($enrolledProject->flag_checkpoint >= 90 ? (99-4) : ($enrolledProject->flag_checkpoint-2)) . '%';
            $content1 = Carbon::parse($enrolledProject->updated_at)->format('d M Y');
            $content2 = 'Project ' . $num;

            $html .= '<p class="absolute font-medium text-left flex-wrap overflow-hidden whitespace-nowrap text-[8px]" style="margin-left: '. $marginLeft1 . '">
                        '. $content1 .'
                     </p>
                     <p class="absolute mt-3 font-medium text-left text-[10px]" style="margin-left: '. $marginLeft2 . '">
                        '. $content2 .'
                     </p>
                     ';

            $num++;
        }

        echo $html;
    }
}
