<?php

namespace App\Exports;

use App\transaksi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MasukExport implements FromView, WithTitle ,ShouldAutoSize
{
    protected $transaksiMasuk;
    protected $start;
    protected $end;

    function __construct($transaksiMasuk, $start, $end) {
        $this->transaksiMasuk = $transaksiMasuk;
        $this->start = $start;
        $this->end = $end;
    }
    public function view(): View
    {
        return view ('excel/transaksiMasuk',[
            'transaksiMasuk'=> $this->transaksiMasuk,
            'start'=> $this->start,
            'end'=> $this->end
        ]);
    }
    public function title(): string
    {
        return 'Transaksi Masuk';
    }
}
