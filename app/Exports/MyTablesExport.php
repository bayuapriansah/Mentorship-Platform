<?php

namespace App\Exports;

use App\Models\MyTable;
use Maatwebsite\Excel\Concerns\FromCollection;

class MyTablesExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public $datefrom, $dateto;

    public $showmodal;

    /* constructor */
    function __construct($datefrom, $dateto)
    {
        $this->datefrom = $datefrom;
        $this->dateto = $dateto;
    }

    public function collection()
    {

        if ($this->datefrom != null && $this->dateto != null) {
            return MyTable::select("name", "age", "gender", "email", "created_at")->whereBetween("created_at", [$this->datefrom, $this->dateto])->get();
        }
        return MyTable::select("name", "age", "gender", "email", "created_at")->get();
    }
}
