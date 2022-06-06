<?php

namespace App\Exports;

use App\kasPendaftaran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KasPendaftaranExport implements FromView , WithTitle ,ShouldAutoSize
{
    
    protected $kasPendaftaran;
    protected $start;
    protected $end;

    function __construct($kasPendaftaran, $start, $end,$saldoSebelum) {
        $this->kasPendaftaran = $kasPendaftaran;
        $this->start = $start;
        $this->end = $end;
        $this->saldoSebelum = $saldoSebelum;
    }
    public function view(): View
    {
        return view ('excel/kasPendaftaranExcel',[
            'kasPendaftaran'=> $this->kasPendaftaran,
            'start'=> $this->start,
            'end'=> $this->end,
            'saldoSebelum'=> $this->saldoSebelum
        ]);
    }
    public function title(): string
    {
        return 'RAB';
    }
}
