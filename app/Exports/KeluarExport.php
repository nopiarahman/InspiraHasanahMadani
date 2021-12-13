<?php

namespace App\Exports;

use App\transaksi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KeluarExport implements FromView, WithTitle ,ShouldAutoSize
{
    protected $transaksiKeluar;
    protected $start;
    protected $end;

    function __construct($transaksiKeluar, $start, $end) {
        $this->transaksiKeluar = $transaksiKeluar;
        $this->start = $start;
        $this->end = $end;
    }
    public function view(): View
    {
        return view ('excel/transaksiKeluar',[
            'transaksiKeluar'=> $this->transaksiKeluar,
            'start'=> $this->start,
            'end'=> $this->end
        ]);
    }
    public function title(): string
    {
        return 'Transaksi Keluar';
    }
}
