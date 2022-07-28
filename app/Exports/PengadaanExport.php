<?php

namespace App\Exports;

use App\isiPengadaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;

class PengadaanExport implements FromView , WithTitle ,ShouldAutoSize
{
    protected $semuaIsi;
    protected $id;
    function __construct($id,$semuaIsi) {
        $this->semuaIsi = $semuaIsi;
        $this->id = $id;
    }
    public function view(): View
    {
        return view ('excel/isiPengadaan',[
            'id'=> $this->id,
            'semuaIsi'=> $this->semuaIsi
        ]);
    }
    public function title(): string
    {
        return 'Pengadaan Barang';
    }
}
