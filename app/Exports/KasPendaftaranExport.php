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

    function __construct($kasPendaftaran, $start, $end) {
        $this->kasPendaftaran = $kasPendaftaran;
        $this->start = $start;
        $this->end = $end;
    }
    public function view(): View
    {
        return view ('excel/kasPendaftaranExcel',[
            'kasPendaftaran'=> $this->kasPendaftaran,
            'start'=> $this->start,
            'end'=> $this->end
        ]);
    }
    public function title(): string
    {
        return 'RAB';
    }
}
