<?php

namespace App\Exports;

use App\Pelanggan;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;

class AktifExport implements FromView , WithTitle ,ShouldAutoSize
{
    protected $pelangganAktif;
    function __construct($pelangganAktif) {
        $this->pelangganAktif = $pelangganAktif;
    }
    public function view(): View
    {
        return view ('excel/pelangganAktif',[
            'pelangganAktif'=> $this->pelangganAktif
        ]);
    }
    public function title(): string
    {
        return 'Pelanggan Aktif';
    }
}
