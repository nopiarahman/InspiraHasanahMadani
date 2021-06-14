<?php

namespace App\Exports;

use App\transaksi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanTahunanExport implements FromView ,ShouldAutoSize
{
    
    protected $produksi;
    protected $start;
    protected $end;
    protected $operasional;
    protected $nonOperasional;
    protected $pendapatanLain;

    function __construct($produksi,$start,$end,$operasional,$nonOperasional,$pendapatanLain) {
        $this->produksi = $produksi;
        $this->start = $start;
        $this->end = $end;
        $this->operasional = $operasional;
        $this->nonOperasional = $nonOperasional;
        $this->pendapatanLain = $pendapatanLain;
    }
    public function view(): View
    {
        return view ('excel/laporanTahunanExcel',[
            'produksi'=> $this->produksi,
            'start'=> $this->start,
            'end'=> $this->end,
            'operasional'=> $this->operasional,
            'nonOperasional'=> $this->nonOperasional,
            'pendapatanLain'=> $this->pendapatanLain
        ]);
    }
}
