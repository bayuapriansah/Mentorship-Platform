<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\Student;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class SubmissionsTable extends Component
{
    use WithPagination;

    public Project $project;

    public $limit = 10;
    public $search = '';
    public $sortField = 'student.name';
    public $sortDirection = 'asc';
    public $filterByMentor = 'my';

    public $sortOptions = [
        'student.name' => 'Participant Name',
        'created_at' => 'Started on',
        'updated_at' => 'Submitted on',
    ];

    public function render()
    {
        return view('livewire.submissions-table', [
            'submissions' => $this->getSubmissions(),
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

    public function getSubmissions()
    {
        $query = Submission::query()
                    ->with('grade', 'student', 'projectSection')
                    ->where('project_id', $this->project->id)
                    ->whereNotNull('file');

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
                        })
                        ->orWhereHas('projectSection', function ($q) use ($search) {
                            $q->where('title', 'LIKE', $search);
                        });
        }

        $query = $this->sortSubmissions($query);

        return $query->paginate($this->limit);
    }

    public function sortSubmissions($query)
    {
        switch ($this->sortField) {
            case 'student.name':
                return $query->orderBy(
                    Student::select('first_name')->whereColumn('id', 'submissions.student_id'),
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
