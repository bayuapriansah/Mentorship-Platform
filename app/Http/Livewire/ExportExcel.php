<?php

namespace App\Http\Livewire;

use App\Exports\MyTablesExport;
use App\Models\Mytable;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ExportExcel extends Component
{
    public $data;

    public $datefrom, $dateto,$modal;


    function mount()
    {
        $this->data = Mytable::all();
    }
    public function render()
    {
        return view('livewire.export-excel')->layout("layouts.livewire");
    }
    function export()
    {
        $this->validate([
            "datefrom" => "required_with:dateto",
            "dateto" => "required_with:datefrom",
        ]);
        return Excel::download(new MyTablesExport($this->datefrom,$this->dateto), "mytable.xlsx");
    }
    function openmodal() {
        $this->modal = true;
    }
    function closemodal() {
        $this->modal = false;
        $this->datefrom = null;
        $this->dateto = null;
    }
}
