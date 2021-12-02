<?php

namespace App\Exports;

use App\pelanggan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class EsTunggakanExport implements FromView ,ShouldAutoSize
{
    protected $start;
    protected $end;
    protected $DPtertunggak;
    protected $cicilanTertunggak;
    function __construct($start,$end,$DPtertunggak,$cicilanTertunggak) {
        $this->start = $start;
        $this->end = $end;
        $this->DPtertunggak = $DPtertunggak;
        $this->cicilanTertunggak = $cicilanTertunggak;
    }
    public function view(): View
    {
        return view ('excel/EsTunggakanExport',[
            'start'=> $this->start,
            'end'=> $this->end,
            'DPtertunggak'=> $this->DPtertunggak,
            'cicilanTertunggak'=> $this->cicilanTertunggak,
        ]);
    }

}
