<?php

namespace App\Exports;

use App\pelanggan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EsDpExport implements FromView ,ShouldAutoSize
{
    protected $start;
    protected $end;
    protected $dpAktif;
    function __construct($start,$end,$dpAktif) {
        $this->dpAktif = $dpAktif;
        $this->start = $start;
        $this->end = $end;
    }
    public function view(): View
    {
        return view ('excel/EsDpExport',[
            'dpAktif'=> $this->dpAktif,
            'start'=> $this->start,
            'end'=> $this->end,
        ]);
    }
}
