<?php

namespace App\Exports;

use App\rab;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PengeluaranRABExport implements FromView , WithTitle ,ShouldAutoSize
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
        return view ('excel/PengeluaranRAB',[
            'transaksiKeluar'=> $this->transaksiKeluar,
            'totalFilter'=> $this->totalFilter,
            'bulanTerpilih'=> $this->bulanTerpilih,
            'id'=> $this->id
        ]);
    }
    public function title(): string
    {
        return 'Pengeluaran RAB';
    }
}
