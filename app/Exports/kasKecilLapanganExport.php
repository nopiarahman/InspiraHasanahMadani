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
    protected $saldoSebelum;

    function __construct($kasKecilLapangan, $start, $end,$saldoSebelum) {
        $this->kasKecilLapangan = $kasKecilLapangan;
        $this->start = $start;
        $this->end = $end;
        $this->saldoSebelum = $saldoSebelum;
    }
    public function view(): View
    {
        return view ('excel/kasKecilLapanganExcel',[
            'kasKecilLapangan'=> $this->kasKecilLapangan,
            'start'=> $this->start,
            'end'=> $this->end,
            'saldoSebelum'=> $this->saldoSebelum
        ]);
    }
}
