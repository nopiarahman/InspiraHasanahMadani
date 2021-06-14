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

    function __construct($cashFlow, $start, $end) {
        $this->cashFlow = $cashFlow;
        $this->start = $start;
        $this->end = $end;
    }
    public function view(): View
    {
        return view ('excel/kasBesar',[
            'cashFlow'=> $this->cashFlow,
            'start'=> $this->start,
            'end'=> $this->end
        ]);
    }
    public function title(): string
    {
        return 'RAB';
    }
}
