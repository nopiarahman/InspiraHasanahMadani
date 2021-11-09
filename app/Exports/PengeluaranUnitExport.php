<?php

namespace App\Exports;

use App\rabUnit;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PengeluaranUnitExport implements FromView , WithTitle ,ShouldAutoSize
{
    protected $transaksiKeluar;
    protected $totalFilter;
    protected $bulanTerpilih;
    protected $id;

    function __construct($transaksiKeluar,$totalFilter,$id,$bulanTerpilih) {
        $this->transaksiKeluar = $transaksiKeluar;
        $this->totalFilter = $totalFilter;
        $this->bulanTerpilih = $bulanTerpilih;
        $this->id = $id;
    }
    public function view(): View
    {
        return view ('excel/PengeluaranUnit',[
            'transaksiKeluar'=> $this->transaksiKeluar,
            'totalFilter'=> $this->totalFilter,
            'bulanTerpilih'=> $this->bulanTerpilih,
            'id'=> $this->id
        ]);
    }
    public function title(): string
    {
        return 'Pengeluaran Unit';
    }
}
