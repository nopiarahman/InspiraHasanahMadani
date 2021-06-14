<?php

namespace App\Exports;

use App\pettyCash;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PettyCashExport implements FromView , WithTitle ,ShouldAutoSize
{
    
    protected $pettyCash;
    protected $start;
    protected $end;

    function __construct($pettyCash, $start, $end) {
        $this->pettyCash = $pettyCash;
        $this->start = $start;
        $this->end = $end;
    }
    public function view(): View
    {
        return view ('excel/pettyCashExcel',[
            'pettyCash'=> $this->pettyCash,
            'start'=> $this->start,
            'end'=> $this->end
        ]);
    }
    public function title(): string
    {
        return 'RAB';
    }
}
