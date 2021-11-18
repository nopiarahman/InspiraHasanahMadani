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
    protected $mts;
    protected $ats;
    protected $semuaRAB;
    protected $semuaUnit;
    protected $transaksiAset;
    protected $bulan;
    protected $tahuniniStart;

    function __construct($transaksiAset,$ats,$pendapatan,$start,$end,$mts,$bulan,$tahuniniStart,$semuaRAB,$semuaUnit) {
        $this->pendapatan = $pendapatan;
        $this->start = $start;
        $this->end = $end;
        $this->mts = $mts;
        $this->ats = $ats;
        $this->semuaRAB = $semuaRAB;
        $this->semuaUnit = $semuaUnit;
        $this->transaksiAset = $transaksiAset;
        $this->bulan = $bulan;
        $this->tahuniniStart = $tahuniniStart;
    }
    public function view(): View
    {
        return view ('excel/laporanBulananExcel',[
            'pendapatan'=> $this->pendapatan,
            'start'=> $this->start,
            'end'=> $this->end,
            'mts'=> $this->mts,
            'ats'=> $this->ats,
            'semuaRAB'=> $this->semuaRAB,
            'semuaUnit'=> $this->semuaUnit,
            'transaksiAset'=> $this->transaksiAset,
            'bulan'=> $this->bulan,
            'tahuniniStart'=> $this->tahuniniStart
        ]);
    }
}
