<?php

namespace App\Exports;

use App\Pelanggan;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;

class NonAktifExport implements FromView , WithTitle ,ShouldAutoSize
{
    protected $pelangganNonAktif;
    function __construct($pelangganNonAktif) {
        $this->pelangganNonAktif = $pelangganNonAktif;
    }
    public function view(): View
    {
        return view ('excel/pelangganNonAktif',[
            'pelangganNonAktif'=> $this->pelangganNonAktif
        ]);
    }
    public function title(): string
    {
        return 'Pelanggan Aktif';
    }
}
