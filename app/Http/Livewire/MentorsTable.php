<?php

namespace App\Http\Livewire;

use App\Models\Institution;
use App\Models\Mentor;
use Livewire\Component;
use Livewire\WithPagination;

class MentorsTable extends Component
{
    use WithPagination ;

    public bool $isStaff;
    public $pageName;

    public $limit = 5;
    public $search = '';
    public $sortField = 'first_name';
    public $sortDirection = 'asc';

    public $sortOptions = [
        'first_name' => 'Name',
        'email' => 'Email',
        // 'created_at' => 'Joining Date',
    ];

    public function mount()
    {
        $this->pageName = $this->isStaff ? 'staffs' : 'mentors';
    }

    public function render()
    {
        return view('livewire.mentors-table', [
            'mentors' => $this->getMentors(),
        ]);
    }

    public function paginationView()
    {
        return 'livewire._participants-table-pagination';
    }

    public function getMentors()
    {
        $query = Mentor::query();

        if (!empty(trim($this->search))) {
            $search = '%'. $this->search. '%';

            $query = $query->whereRaw("CONCAT(first_name,' ', last_name) like ?", [$search])
                    ->orWhere('email', 'like', $search);
        }

        if ($this->isStaff) {
            $query = $query->where('institution_id',  0);
        } else {
            $institution_id = Institution::orderBy('id')->first()->id;
            $query = $query->where('institution_id',  $institution_id);
        }

        return $query = $query->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->limit, ['*'], $this->pageName . 'Page');
    }

    public function updatingSearch()
    {
        $this->resetPage($this->pageName . 'Page');
    }

    public function resetSearch()
    {
        $this->search = '';
    }
}
