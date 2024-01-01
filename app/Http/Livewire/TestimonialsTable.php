<?php

namespace App\Http\Livewire;

use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use Nnjeim\World\Models\Country;

class TestimonialsTable extends Component
{
    use WithPagination;

    public $countries;

    public $limit = 10;
    public $search = '';
    public $sortField = 'first_name';
    public $sortDirection = 'asc';
    public $filterByMentorshipType = '';
    public $filterByCountry = '';

    public $sortOptions = [
        'first_name' => 'Name',
        'email' => 'Email',
        'team_name' => 'Team Name',
        'country' => 'Country',
    ];

    public function render()
    {
        return view('livewire.testimonials-table', [
            'participants' => $this->getParticipants(),
        ]);
    }

    public function mount()
    {
        $this->countries = Country::orderBy('name')->get();
    }

    public function paginationView()
    {
        return 'livewire._participants-table-pagination';
    }

    private function getParticipants()
    {
        $query = Student::query()
                    ->with('mentor', 'staff')
                    ->has('feedback');

        if (!empty(trim($this->search))) {
            $search = '%'. $this->search. '%';

            $query = $query->whereRaw("CONCAT(first_name,' ', last_name) LIKE ?", [$search])
                        ->orWhere('email', 'LIKE', $search)
                        ->orWhereHas('mentor', function ($query) use ($search) {
                            $query->whereRaw("CONCAT(first_name,' ', last_name) LIKE ?", [$search]);
                        })
                        ->orWhereHas('staff', function ($query) use ($search) {
                            $query->whereRaw("CONCAT(first_name,' ', last_name) LIKE ?", [$search]);
                        })
                        ->orWhere('country', 'LIKE', $search)
                        ->orWhere('team_name', 'LIKE', $search)
                        ->orWhere('mentorship_type', 'LIKE', $search);
        }

        if (!empty($this->filterByMentorshipType)) {
            $query = $query->where('mentorship_type', $this->filterByMentorshipType);
        }

        if (!empty($this->filterByCountry)) {
            $query = $query->where('country', $this->filterByCountry);
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

    public function resetAllFilters()
    {
        $this->filterByMentorshipType = '';
        $this->filterByCountry = '';
    }
}
