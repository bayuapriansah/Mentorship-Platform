<?php

namespace App\Http\Livewire;

use App\Imports\MyData;
use App\Models\Mytable;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class UploadExcel extends Component
{
    use WithFileUploads;
    public $file;
    public $data;
    public function mount()
    {
    }
    public function render()
    {
        if ($this->file) {
            $this->data = Excel::toArray(new MyData, $this->file->path())[0];
        }
        return view('livewire.upload-excel')->layout("layouts.livewire");
    }
    function save()
    {
        foreach ($this->data as $key => $value) {
            if ($key == 0) {
                continue;
            }
            Mytable::create([
                "name" => $value[0],
                "age" => $value[1],
                "gender" => $value[2],
                "email" => $value[3],
            ]);
        }
    }
}
