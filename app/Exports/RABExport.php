<?php

namespace App\Exports;

use App\rab;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RABExport implements FromView , WithTitle ,ShouldAutoSize
{
    
    protected $semuaRAB;
    protected $semuaUnit;

    function __construct($semuaRAB,$semuaUnit) {
        $this->semuaRAB = $semuaRAB;
        $this->semuaUnit = $semuaUnit;
    }
    public function view(): View
    {
        return view ('excel/RAB',[
            'semuaRAB'=> $this->semuaRAB,
            'semuaUnit'=> $this->semuaUnit
        ]);
    }
    public function title(): string
    {
        return 'RAB';
    }
}
