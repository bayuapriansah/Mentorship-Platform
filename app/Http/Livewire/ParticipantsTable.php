<?php

namespace App\Http\Livewire;

use App\Http\Controllers\SimintEncryption;
use App\Models\EnrolledProject;
use App\Models\Mentor;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Nnjeim\World\Models\Country;

class ParticipantsTable extends Component
{
    use WithPagination;

    public $countries;
    public $enrolledProjects;
    public $mentors;
    public $staffs;

    public $limit = 10;
    public $search = '';
    public $sortField = 'first_name';
    public $sortDirection = 'asc';
    public $filterByMentorshipType = '';
    public $filterByCountry = '';

    public $sortOptions = [
        'first_name' => 'Participant Name',
        'mentor.name' => 'Mentor Name',
        'staff.name' => 'Staff Name',
        'country' => 'Country',
        'team_name' => 'Team Name',
    ];

    public function render()
    {
        return view('livewire.participants-table', $this->getViewData());
    }

    public function mount()
    {
        $this->countries = Country::orderBy('name')->get();
        $this->enrolledProjects = EnrolledProject::all();
        $this->mentors = Mentor::where('institution_id', '!=', 0)->where('is_confirm', 1)->get();
        $this->staffs = Mentor::where('institution_id', 0)->where('is_confirm', 1)->get();
    }

    public function paginationView()
    {
        return 'livewire._participants-table-pagination';
    }

    private function getViewData()
    {
        return [
            'participants' => $this->getParticipants(),
        ];
    }

    private function getParticipants()
    {
        $guard = Auth::guard('web')->check() ? 'web' : (Auth::guard('mentor')->check() ? 'mentor' : (Auth::guard('customer')->check() ? 'customer' : null));

        $query = Student::query()
            ->with('mentor', 'staff')
            ->where('is_confirm', true);

        //
        switch ($guard) {
            case 'web':
                //
                break;
            case 'mentor':
                $mentor = Auth::guard('mentor')->user();
                $query = ($mentor->institution_id != 0)
                    ? $query->where('mentor_id', $mentor->id)
                    : $query->where('staff_id', $mentor->id);

                break;
            case 'customer':
                $companyId = Auth::guard('customer')->user()->company_id;
                $query = $query->whereHas('enrolled_projects', function ($q) use ($companyId) {
                    $q->whereHas('project', function ($q) use ($companyId) {
                        $q->where('company_id', $companyId);
                    });
                });

                break;
            default:
                abort(403, 'Unauthorized action.');
                break;
        }

        if (!empty(trim($this->search))) {
            $search = '%' . $this->search . '%';
            $query = $query->where(function ($queryinsite) use ($search) {
                $queryinsite->whereRaw("CONCAT(first_name,' ', last_name) like?", [$search])
                ->orWhereHas('mentor', function ($query) use ($search) {
                    $query->whereRaw("CONCAT(first_name,' ', last_name) like?", [$search]);
                })
                ->orWhereHas('staff', function ($query) use ($search) {
                    $query->whereRaw("CONCAT(first_name,' ', last_name) like?", [$search]);
                })
                ->orWhere('country', 'like', $search)
                ->orWhere('team_name', 'like', $search)
                ->orWhere('mentorship_type', 'like', $search);
            });

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
        $tipNumber = 1;
        $arr = $this->enrolledProjects->where('is_submited', 1)->where('student_id',  $participant->id);
        $html = '';

        foreach ($arr as $key => $enrolledProject) {
            $marginLeft = ($enrolledProject->flag_checkpoint >= 90 ? '90' : ($enrolledProject->flag_checkpoint - 4)) . '%';
            $content = (substr($enrolledProject->project->name, 0, 15)) . (strlen($enrolledProject->project->name) >= 15 ? '...' : '');
            $imgSrc = asset('/assets/img/icon/flag.png');
            $imgMarginLeft = ($enrolledProject->flag_checkpoint >= 90 ? '99' : $enrolledProject->flag_checkpoint) . '%';

            $html .= '<p class="absolute -top-5 font-medium text-left flex-wrap text-[10px] overflow-hidden whitespace-nowrap" style="margin-left: ' . $marginLeft . '">
                        ' . $content . '
                      </p>
                      <img src="' . $imgSrc . '" class="absolute top-0" style="margin-left: ' . $imgMarginLeft . '">
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
            $marginLeft1 = ($enrolledProject->flag_checkpoint >= 90 ? (100 - 6) : ($enrolledProject->flag_checkpoint - 2)) . '%';
            $marginLeft2 = ($enrolledProject->flag_checkpoint >= 90 ? (99 - 4) : ($enrolledProject->flag_checkpoint - 2)) . '%';
            $content1 = Carbon::parse($enrolledProject->updated_at)->format('d M Y');
            $content2 = 'Project ' . $num;

            $html .= '<p class="absolute font-medium text-left flex-wrap overflow-hidden whitespace-nowrap text-[8px]" style="margin-left: ' . $marginLeft1 . '">
                        ' . $content1 . '
                     </p>
                     <p class="absolute mt-3 font-medium text-left text-[10px]" style="margin-left: ' . $marginLeft2 . '">
                        ' . $content2 . '
                     </p>
                     ';

            $num++;
        }

        echo $html;
    }

    public function assignMentor($mentor_id, $participant_ids)
    {
        Student::whereIn('id', $participant_ids)->update(['mentor_id' => $mentor_id]);
        $this->resetPage();
    }

    public function assignStaff($staff_id, $participant_ids)
    {
        Student::whereIn('id', $participant_ids)->update(['staff_id' => $staff_id]);
        $this->resetPage();
    }
}
