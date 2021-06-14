<?php

namespace App\Exports;

use App\rabUnit;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UnitExport implements FromView , WithTitle ,ShouldAutoSize
{
    
    protected $semuaRAB;

    function __construct($semuaRAB) {
        $this->semuaRAB = $semuaRAB;
    }
    public function view(): View
    {
        return view ('excel/rabUnitExcel',[
            'semuaRAB'=> $this->semuaRAB
        ]);
    }
    public function title(): string
    {
        return 'RAB';
    }
}
