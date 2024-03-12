<?php

namespace App\Http\Livewire;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EnrolledProject;
use Illuminate\Support\Facades\Auth;

class ProjectsTable extends Component
{
    use WithPagination;

    public $partnerId;
    public $isDraft;

    public $limit = 10;
    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';

    public $sortOptions = [
        'name' => 'Project Name',
        'project_domain' => 'Project Domain',
        'enrolled_project_count' => 'Total Enrollment',
        'created_at' => 'Added on',
    ];

    public function render()
    {
        return view('livewire.projects-table', [
            'projects' => $this->getProjects(),
        ]);
    }

    public function mount($partnerId, $isDraft)
    {
        $this->partnerId = $partnerId;
        $this->isDraft = $isDraft;
    }

    public function paginationView()
    {
        return 'livewire._participants-table-pagination';
    }

    public function getProjects()
    {
        if ($this->partnerId) {
            return $this->getPartnerProjects();
        }

        $query = Project::query()->withCount('enrolled_project');

        if ($this->isDraft) {
            $query = $query->where('status', 'draft');
        }

        if (!empty(trim($this->search))) {
            $search = '%'. $this->search. '%';

            $query = $query->where('name', 'LIKE', $search)
                        ->orWhere('project_domain', 'LIKE', $search);
        }

        return $query->orderBy($this->sortField, $this->sortDirection)->paginate($this->limit);
    }

    public function getPartnerProjects()
    {
        $query = Project::query()
                    ->withCount('enrolled_project')
                    ->where('company_id', $this->partnerId);

        if (!empty(trim($this->search))) {
            $search = '%'. $this->search. '%';

            $query = $query->where('name', 'LIKE', $search)
                        ->orWhere('project_domain', 'LIKE', $search);
        }

        return $query->orderBy($this->sortField, $this->sortDirection)->paginate($this->limit);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetSearch()
    {
        $this->search = '';
    }

    public function countEnrolled($project)
    {
        if (Auth::guard('mentor')->check()) {
            $query = EnrolledProject::query()->where('project_id', $project->id);

            if (Auth::guard('mentor')->user()->institution_id != 0) {
                $query = $query->whereHas('student', function ($q) {
                    $q->where('institution_id', Auth::guard('mentor')->user()->institution_id);
                });

                $query = $query->whereHas('student', function ($q) {
                    $q->where('mentor_id', Auth::guard('mentor')->user()->id);
                });
            } else {
                $query = $query->whereHas('student', function ($q) {
                    $q->where('staff_id', Auth::guard('mentor')->user()->id);
                });
            }

            return $query->count();
        } else {
            return $project->enrolled_project_count;
        }
    }
}
