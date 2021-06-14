<?php

namespace App\Exports;

use App\transaksi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanBulananExport implements FromView ,ShouldAutoSize
{
    
    protected $pendapatan;
    protected $start;
    protected $end;
    protected $kategoriAkun;

    function __construct($pendapatan,$start,$end,$kategoriAkun) {
        $this->pendapatan = $pendapatan;
        $this->start = $start;
        $this->end = $end;
        $this->kategoriAkun = $kategoriAkun;
    }
    public function view(): View
    {
        return view ('excel/laporanBulananExcel',[
            'pendapatan'=> $this->pendapatan,
            'start'=> $this->start,
            'end'=> $this->end,
            'kategoriAkun'=> $this->kategoriAkun
        ]);
    }
}
