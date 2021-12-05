<?php

namespace App\Exports;

use App\transaksi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KasBesarExport implements FromView , WithTitle ,ShouldAutoSize
{
    
    protected $cashFlow;
    protected $start;
    protected $end;

    function __construct($saldoSebelum,$cashFlow, $start, $end) {
        $this->saldoSebelum = $saldoSebelum;
        $this->cashFlow = $cashFlow;
        $this->start = $start;
        $this->end = $end;
    }
    public function view(): View
    {
        return view ('excel/kasBesar',[
            'saldoSebelum'=> $this->saldoSebelum,
            'cashFlow'=> $this->cashFlow,
            'start'=> $this->start,
            'end'=> $this->end
        ]);
    }
    public function title(): string
    {
        return 'Kas Besar';
    }
}
