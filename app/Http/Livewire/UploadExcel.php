<?php

namespace App\Http\Livewire;

use App\Imports\MyData;
use App\Models\Mytable;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Exceptions\NoTypeDetectedException;
use Maatwebsite\Excel\Facades\Excel;

class UploadExcel extends Component
{
    use WithFileUploads;
    public $file;
    public $data;
    public $typeerror;
    public function mount()
    {
    }
    protected $rules = [
        "file" => "mimes:xlsx"
    ];
    public function render()
    {
        if ($this->file ) {
            try {
                $this->data = Excel::toArray(new MyData, $this->file->path())[0];
                $this->typeerror = false;
            } catch (\Throwable $th) {
                if ($th instanceof NoTypeDetectedException) {
                    $this->typeerror = "File type not supported";
                }
            }
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
