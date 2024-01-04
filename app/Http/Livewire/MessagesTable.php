<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\ProjectSection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MessagesTable extends Component
{
    use WithPagination;

    public $projects;

    public $limit = 10;
    public $search = '';
    public $sortField = 'project.name';
    public $sortDirection = 'asc';
    public $filterByProject = '';
    public $filterByProjectDomain = '';

    public $sortOptions = [
        'project.name' => 'Project Name',
        'project.domain' => 'Project Domain',
        'title' => 'Task Name',
    ];

    public $projectOptions = [];
    public $projectDomainOptions = [];

    public function render()
    {
        return view('livewire.messages-table', [
            'projectSections' => $this->getProjectSections(),
        ]);
    }

    public function mount()
    {
        $this->projects = Project::orderBy('name')->get();
        $this->projectOptions = $this->projects->pluck('name', 'id');

        foreach ($this->projects as $project) {
            $domain = $project->getProjectDomainText();

            if (!in_array($domain, $this->projectDomainOptions)) {
                $this->projectDomainOptions[$project->project_domain] = $domain;
            }
        }

        asort($this->projectDomainOptions);
    }

    public function paginationView()
    {
        return 'livewire._participants-table-pagination';
    }

    public function getProjectSections()
    {
        $query = ProjectSection::query();

        if (Auth::guard('web')->check()) {
            $query = $query->whereHas('comment');
        } elseif (Auth::guard('mentor')->check()) {
            $fk = Auth::guard('mentor')->user()->institution_id == 0 ? 'staff_id' : 'mentor_id';

            $query = $query->whereHas('comment', function ($q) use ($fk) {
                $q->whereHas('student', function ($q) use ($fk) {
                    $q->where($fk, Auth::guard('mentor')->user()->id);
                });
            });
        } elseif(Auth::guard('customer')->check()) {
            $query = $query->whereHas('comment', function ($q) {
                $q->whereHas('project', function ($q) {
                    $q->where('company_id', Auth::guard('customer')->user()->company_id);
                });
            });
        }

        if (!empty(trim($this->search))) {
            $search = '%'. $this->search. '%';

            $query = $query->where('title', 'LIKE', $search)
                            ->orWhereHas('project', function ($q) use ($search) {
                                $q->where('name', 'LIKE', $search)
                                    ->orWhere('project_domain', 'LIKE', $search);
                            });
        }

        if (!empty($this->filterByProject)) {
            $query = $query->where('project_id', $this->filterByProject);
        }

        if (!empty($this->filterByProjectDomain)) {
            $query = $query->whereHas('project', function ($q) {
                $q->where('project_domain', $this->filterByProjectDomain);
            });
        }

        $query = $this->sortData($query);

        return $query->paginate($this->limit);
    }

    public function sortData($query)
    {
        switch ($this->sortField) {
            case 'project.name':
                return $query->orderBy(
                    Project::select('name')->whereColumn('id', 'project_sections.project_id'),
                    $this->sortDirection
                );

            case 'project.domain':
                return $query->orderBy(
                    Project::select('project_domain')->whereColumn('id', 'project_sections.project_id'),
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
        $this->filterByProject = '';
        $this->filterByProjectDomain = '';
    }
}
