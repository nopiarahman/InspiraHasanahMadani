<?php

namespace App\Exports;

use App\pelanggan;
use Maatwebsite\Excel\Concerns\FromCollection;

class EsTunggakanExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return pelanggan::all();
    }
}
