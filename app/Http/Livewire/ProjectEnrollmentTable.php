<?php

namespace App\Http\Livewire;

use App\Models\EnrolledProject;
use App\Models\Mentor;
use App\Models\Project;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectEnrollmentTable extends Component
{
    use WithPagination;

    public Project $project;

    public $limit = 10;
    public $search = '';
    public $sortField = 'student.name';
    public $sortDirection = 'asc';
    public $filterByMentor = 'all';

    public $sortOptions = [
        'student.name' => 'Participant Name',
        'student.mentor.name' => 'Mentor Name',
        'student.team_name' => 'Team Name',
        'student.institution.name' => 'Institution Name',
    ];

    public function render()
    {
        return view('livewire.project-enrollment-table', [
            'enrolledProjects' => $this->getEnrolledProjects(),
        ]);
    }

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function paginationView()
    {
        return 'livewire._participants-table-pagination';
    }

    public function getEnrolledProjects()
    {
        $query = EnrolledProject::query()->where('project_id', $this->project->id);

        if (Auth::guard('mentor')->check()) {
            if (Auth::guard('mentor')->user()->institution_id != 0) {
                $query = $query->whereHas('student', function ($q) {
                    $q->where('institution_id', Auth::guard('mentor')->user()->institution_id);
                });

                if ($this->filterByMentor !== 'all') {
                    $query = $query->whereHas('student', function ($q) {
                        $q->where('mentor_id', Auth::guard('mentor')->user()->id);
                    });
                }
            } else {
                $query = $query->whereHas('student', function ($q) {
                    $q->where('staff_id', Auth::guard('mentor')->user()->id);
                });
            }
        }

        if (!empty(trim($this->search))) {
            $search = '%'. $this->search. '%';

            $query = $query->whereHas('student', function ($q) use ($search) {
                            $q->whereRaw("CONCAT(first_name,' ', last_name) LIKE ?", [$search]);
                        });
        }

        $query = $this->sortData($query);

        return $query->paginate($this->limit);
    }

    public function sortData($query)
    {
        switch ($this->sortField) {
            case 'student.name':
                return $query->orderBy(
                    Student::select('first_name')->whereColumn('id', 'enrolled_projects.student_id'),
                    $this->sortDirection
                );

            case 'student.team_name':
                return $query->orderBy(
                    Student::select('team_name')->whereColumn('id', 'enrolled_projects.student_id'),
                    $this->sortDirection
                );

            case 'student.mentor.name':
                return $query->orderBy(
                    Student::join('mentors','mentors.id', '=', 'students.mentor_id')
                            ->select('mentors.first_name')
                            ->whereColumn('students.id', 'enrolled_projects.student_id'),
                    $this->sortDirection
                );

            case 'student.institution.name':
                return $query->orderBy(
                    Student::join('institutions', 'institutions.id', '=', 'students.institution_id')
                            ->select('institutions.name')
                            ->whereColumn('students.id', 'enrolled_projects.student_id'),
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
}
