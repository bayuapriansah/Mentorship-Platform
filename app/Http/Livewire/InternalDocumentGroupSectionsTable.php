<?php

namespace App\Http\Livewire;

use App\Models\InternalDocumentGroupSection;
use Livewire\Component;
use Livewire\WithPagination;

class InternalDocumentGroupSectionsTable extends Component
{
    use WithPagination;

    public $limit = 10;
    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';

    public $sortOptions = [
        'name' => 'Section Name',
    ];

    public function render()
    {
        return view('livewire.internal-document-group-sections-table', [
            'internalDocumentGroupSections' => $this->gertInternalDocumentGroupSections(),
        ]);
    }

    public function paginationView()
    {
        return 'livewire._participants-table-pagination';
    }

    public function gertInternalDocumentGroupSections()
    {
        $query = InternalDocumentGroupSection::query();

        if (!empty(trim($this->search))) {
            $search = '%'. $this->search. '%';

            $query = $query->where('name', 'LIKE', $search);
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

    public function draftSection($id)
    {
        InternalDocumentGroupSection::where('id', $id)->update(['is_draft' => true]);
        $this->resetPage();
    }

    public function publishSection($id)
    {
        InternalDocumentGroupSection::where('id', $id)->update(['is_draft' => false]);
        $this->resetPage();
    }

    public function deleteSection($id)
    {
        if (!$id) {
            toastr()->error('Missing group section ID');
            return;
        }

        $section = InternalDocumentGroupSection::find($id);
        $section->internalDocumentPages->each->delete();
        $section->delete();

        toastr()->success('Group Section deleted successfully');
        $this->resetPage();
    }

    public function addSection($sectionName)
    {
        if (empty(trim($sectionName))) {
            toastr()->error('Missing group section name');
            return;
        }

        InternalDocumentGroupSection::create(['name' => $sectionName]);

        toastr()->success('Group Section added successfully');
        $this->resetPage();
    }

    public function updateSection($id, $sectionName)
    {
        if (empty(trim($sectionName))) {
            toastr()->error('Missing group section name');
            return;
        }

        InternalDocumentGroupSection::where('id', $id)->update(['name' => $sectionName]);

        toastr()->success('Group Section updated successfully');
        $this->resetPage();
    }
}
