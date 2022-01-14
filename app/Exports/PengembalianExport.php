<?php

namespace App\Exports;

use App\pengembalian;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PengembalianExport implements FromView,ShouldAutoSize
{
    protected $id;
    protected $pengembalian;
    function __construct($id,$pengembalian) {
        $this->id = $id;
        $this->pengembalian = $pengembalian;
    }
    public function view(): View
    {
        return view ('excel/pengembalian',[
            'id'=> $this->id,
            'pengembalian'=> $this->pengembalian,
        ]);
    }
}