<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\ProjectSection;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class TaskMessagesTable extends Component
{
    use WithPagination;

    public ProjectSection $projectSection;
    public $customers;

    public $limit = 10;
    public $search = '';
    public $sortField = 'first_name';
    public $sortDirection = 'asc';

    public $sortOptions = [
        'first_name' => 'Participant Name',
    ];

    public function render()
    {
        return view('livewire.task-messages-table', [
            'participants' => $this->getParticipants(),
        ]);
    }

    public function mount(ProjectSection $projectSection)
    {
        $customer_company_id = Auth::guard('customer')->check() ? Auth::guard('customer')->user()->company_id : $projectSection->project->company_id;

        $this->projectSection = $projectSection;
        $this->customers = Customer::where('company_id', $customer_company_id)->get();
    }

    public function paginationView()
    {
        return 'livewire._participants-table-pagination';
    }

    public function getParticipants()
    {
        $query = Student::query()->whereHas('comment');

        if (Auth::guard('mentor')->check()) {
            $fk = Auth::guard('mentor')->user()->institution_id == 0 ? 'staff_id' : 'mentor_id';
            $query = $query->where($fk, Auth::guard('mentor')->user()->id);
        }

        if (!empty(trim($this->search))) {
            $search = '%'. $this->search. '%';

            $query = $query->whereRaw("CONCAT(first_name,' ', last_name) like?", [$search]);
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

    public function unreadMessagesCount($participant_id)
    {
        $count = commentPerSection($this->projectSection)->where('student_id', $participant_id)->count();

        if ($count > 0) {
            echo $count . ' Unread Messages'; // Corrected concatenation
        }
    }
}
