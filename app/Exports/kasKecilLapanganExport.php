<?php

namespace App\Exports;

use App\kasKecilLapangan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class kasKecilLapanganExport implements FromView  ,ShouldAutoSize
{
    
    protected $kasKecilLapangan;
    protected $start;
    protected $end;

    function __construct($kasKecilLapangan, $start, $end) {
        $this->kasKecilLapangan = $kasKecilLapangan;
        $this->start = $start;
        $this->end = $end;
    }
    public function view(): View
    {
        return view ('excel/kasKecilLapanganExcel',[
            'kasKecilLapangan'=> $this->kasKecilLapangan,
            'start'=> $this->start,
            'end'=> $this->end
        ]);
    }
}
