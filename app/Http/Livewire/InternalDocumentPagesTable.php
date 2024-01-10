<?php

namespace App\Http\Livewire;

use App\Models\InternalDocumentGroupSection;
use App\Models\InternalDocumentPage;
use Livewire\Component;
use Livewire\WithPagination;

class InternalDocumentPagesTable extends Component
{
    use WithPagination;

    public $limit = 10;
    public $search = '';
    public $sortField = 'title';
    public $sortDirection = 'asc';

    public $sortOptions = [
        'title' => 'Page Title',
        'group_section' => 'Group Section',
        'created_at' => 'Release Date',
    ];


    public function render()
    {
        return view('livewire.internal-document-pages-table', [
            'internalDocumentPages' => $this->gertInternalDocumentPages(),
        ]);
    }

    public function paginationView()
    {
        return 'livewire._participants-table-pagination';
    }

    public function gertInternalDocumentPages()
    {
        $query = InternalDocumentPage::query();

        if (!empty(trim($this->search))) {
            $search = '%'. $this->search. '%';

            $query = $query->where('title', 'LIKE', $search)
                        ->orWhereHas('internalDocumentGroupSection', function ($query) use ($search) {
                            $query->where('name', 'LIKE', $search);
                        });
        }

        $query = $this->sortData($query);

        return $query->paginate($this->limit);
    }

    public function sortData($query)
    {
        switch ($this->sortField) {
            case 'group_section':
                return $query->orderBy(
                    InternalDocumentGroupSection::select('name')->whereColumn('id', 'internal_document_group_section_id'),
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

    public function draftPage($id)
    {
        InternalDocumentPage::where('id', $id)->update(['is_draft' => true]);
        $this->resetPage();
    }

    public function publishPage($id)
    {
        InternalDocumentPage::where('id', $id)->update(['is_draft' => false]);
        $this->resetPage();
    }

    public function deletePage($id)
    {
        if (!$id) {
            toastr()->error('Missing page ID');
            return;
        }

        $page = InternalDocumentPage::find($id);
        $page->delete();

        toastr()->success('Page deleted successfully');
        $this->resetPage();
    }
}
