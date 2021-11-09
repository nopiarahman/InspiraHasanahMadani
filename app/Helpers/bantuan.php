<?php
use App\kavling;
use App\dp;
use App\akun;
use App\kios;
use App\gudang;
use App\pembelian;
use App\rumah;
use App\proyek;
use App\cicilan;
use App\pelanggan;
use App\transaksi;
use App\detailUser;
use App\pettyCash;
use App\kasPendaftaran;
use App\kasKecilLapangan;
use Carbon\Carbon;

function cekNamaUser(){
    return auth()->user()->name;
}
function detailUser($id){
    $detail = detailUser::where('user_id',$id)->first();
    if($detail != null){
        return $detail;
    }
    return null;
}
function proyekId(){
    return auth()->user()->proyek_id;
}

function namaProyek(){
    $proyek = proyek::find(proyekId());
    return $proyek->nama;
}

function unitPelanggan($id){
    $unit = kavling::find($id);
    return $unit;
}

function pembelianPelanggan($id){
    $pembelian = pembelian::where('pelanggan_id',$id)->first();
    return($pembelian);
}

function jenisKepemilikan($id){  /* $id = pelanggan_id */
    $pembelian = pembelian::where('pelanggan_id',$id)->first();
    // dd($pembelian);
    if($pembelian->rumah_id !=null){
        return 'Rumah';
    }elseif($pembelian->kios_id !=null){
        return 'Kios';
    }elseif($pembelian->kavling_id !=null){
        return 'Kavling';
    }
}
function saldoTerakhir(){
    $saldo = transaksi::orderBy('no','desc')->where('proyek_id',proyekId())->first();
    $saldoTerakhir=0;
    if($saldo != null){
        $saldoTerakhir=$saldo->saldo;
    }
    return $saldoTerakhir;
}
function noTransaksiTerakhir(){
    $no = transaksi::orderBy('no','desc')->where('proyek_id',proyekId())->first();
    $noTerakhir=0;
    if($no != null){
        $noTerakhir=$no->no;
    }
    return $noTerakhir;
}
function noKasKecilLapanganTerakhir(){
    $no = kasKecilLapangan::orderBy('no','desc')->where('proyek_id',proyekId())->first();
    $noTerakhir=0;
    if($no != null){
        $noTerakhir=$no->no;
    }
    return $noTerakhir;
}
function noPettyCashTerakhir(){
    $no = pettycash::orderBy('no','desc')->where('proyek_id',proyekId())->first();
    $noTerakhir=0;
    if($no != null){
        $noTerakhir=$no->no;
    }
    return $noTerakhir;
}
function totalKasBesar($start,$end){
    $total = transaksi::whereBetween('tanggal',[$start,$end])->where('proyek_id',proyekId())->orderBy('no')->get();
    if($total != null){
        $terakhir = $total->last();
        if($terakhir != null){
            return $terakhir->saldo;
        }else{
            return 0;
        }
    }
    return 0;
    // dd($total);
}
function totalKasPendaftaran($start,$end){
    $total = kasPendaftaran::whereBetween('tanggal',[$start,$end])->where('proyek_id',proyekId())->orderBy('no')->get();
    if($total != null){
        $terakhir = $total->last();
        if($terakhir != null){
            return $terakhir->saldo;
        }else{
            return 0;
        }
    }
    return 0;
    // dd($total);
}
function totalKasKecilLapangan($start,$end){
    $total = kasKecilLapangan::whereBetween('tanggal',[$start,$end])->where('proyek_id',proyekId())->orderBy('no')->get();
    if($total != null){
        $terakhir = $total->last();
        if($terakhir != null){
            return $terakhir->saldo;
        }else{
            return 0;
        }
    }
    return 0;
    // dd($total);
}
function totalPettyCash($start,$end){
    $total = pettyCash::whereBetween('tanggal',[$start,$end])->where('proyek_id',proyekId())->orderBy('no')->get();
    if($total != null){
        $terakhir = $total->last();
        if($terakhir != null){
            return $terakhir->saldo;
        }else{
            return 0;
        }
    }
    return 0;
    // dd($total);
}
function saldoTerakhirKasPendaftaran(){
    $saldo = kasPendaftaran::orderBy('no','desc')->where('proyek_id',proyekId())->first();
    $saldoTerakhir=0;
    if($saldo != null){
        $saldoTerakhir=$saldo->saldo;
    }
    return $saldoTerakhir;
}
function saldoTerakhirKasKecilLapangan(){
    $saldo = kasKecilLapangan::orderBy('no','desc')->where('proyek_id',proyekId())->first();
    $saldoTerakhir=0;
    if($saldo != null){
        $saldoTerakhir=$saldo->saldo;
    }
    return $saldoTerakhir;
}
function saldoTerakhirPettyCash(){
    $saldo = pettyCash::orderBy('no','desc')->where('proyek_id',proyekId())->first();
    $saldoTerakhir=0;
    if($saldo != null){
        $saldoTerakhir=$saldo->saldo;
    }
    return $saldoTerakhir;
}
function kasBesarMasuk($dataArray){
    $data = collect($dataArray);
    // $akunPendapatan=akun::firstOrCreate([
    //     'proyek_id'=>proyekId(),
    //     'jenis'=>'Pendapatan',
    //     'kategori'=>'Pendapatan',
    //     'kodeAkun'=>'Pendapatan',
    //     'namaAkun'=>'Pendapatan',
    // ]);
    $requestData = $data->all();
    $requestData['kredit']=$data->get('kredit');
    $requestData['saldo']=$data->get('saldo');
    $requestData['kategori']='Pendapatan';
    // $requestData['akun_id']=$akunPendapatan->id;
    $requestData['proyek_id']=proyekId();
    // dd($requestData);
    transaksi::create($requestData);
    // return $this; 
}
function saldoSebelumnya($tanggalSekarang){
    $transaksi = transaksi::where('tanggal','<=',$tanggalSekarang)->where('proyek_id',proyekId())->orderBy('tanggal')->get();
    if($transaksi != null){
        $terakhir = $transaksi->last();
        return $terakhir->saldo;
    }else{
        return 0;
    } 
}
function kasBesarKeluar($dataArray)
{
    $data = collect($dataArray);
    $jumlah= str_replace(',', '', $data->get('jumlah'));
    $hargaSatuan= str_replace(',', '', $data->get('hargaSatuan'));
    $total= str_replace(',', '', $data->get('total'));
    $dataTransaksi['tanggal'] = $data->get('tanggal');
    $dataTransaksi['satuan'] = $data->get('satuan');
    $dataTransaksi['rab_id'] = $data->get('rab_id');
    $dataTransaksi['rabunit_id'] = $data->get('rabunit_id');
    $dataTransaksi['akun_id'] = $data->get('akun_id');
    $dataTransaksi['uraian'] = $data->get('uraian');
    $dataTransaksi['sumber'] = $data->get('sumber');
    $dataTransaksi['debet'] = $total;
    $dataTransaksi['jumlah'] = $jumlah;
    $dataTransaksi['hargaSatuan'] = $hargaSatuan;
    $dataTransaksi['no'] = $data->get('no');
    $dataTransaksi['saldo'] = $data->get('saldo');
    $dataTransaksi['proyek_id'] = proyekId();
    dd($dataTransaksi);
    transaksi::create($dataTransaksi);
}
function pettyCashKeluar($dataArray)
{
    $data = collect($dataArray);
    $jumlah= str_replace(',', '', $data->get('jumlah'));
    $hargaSatuan= str_replace(',', '', $data->get('hargaSatuan'));
    $total= str_replace(',', '', $data->get('total'));
    $dataTransaksi['tanggal'] = $data->get('tanggal');
    $dataTransaksi['uraian'] = $data->get('uraian');
    $dataTransaksi['satuan'] = $data->get('satuan');
    $dataTransaksi['sumber'] = $data->get('sumber');
    $dataTransaksi['keterangan'] = $data->get('keterangan');
    $dataTransaksi['debet'] = $total;
    $dataTransaksi['jumlah'] = $jumlah;
    $dataTransaksi['hargaSatuan'] = $hargaSatuan;
    $dataTransaksi['no'] = $data->get('no');
    $dataTransaksi['saldo'] = $data->get('saldo');
    $dataTransaksi['proyek_id'] = proyekId();
    pettyCash::create($dataTransaksi);
    // dd($dataTransaksi);
}
function kasLapanganKeluar($dataArray)
{
    $data = collect($dataArray);
    $jumlah= str_replace(',', '', $data->get('jumlah'));
    $hargaSatuan= str_replace(',', '', $data->get('hargaSatuan'));
    $total= str_replace(',', '', $data->get('total'));
    $dataTransaksi['tanggal'] = $data->get('tanggal');
    $dataTransaksi['uraian'] = $data->get('uraian');
    $dataTransaksi['satuan'] = $data->get('satuan');
    $dataTransaksi['sumber'] = $data->get('sumber');
    $dataTransaksi['keterangan'] = $data->get('keterangan');
    $dataTransaksi['debet'] = $total;
    $dataTransaksi['jumlah'] = $jumlah;
    $dataTransaksi['hargaSatuan'] = $hargaSatuan;
    $dataTransaksi['no'] = $data->get('no');
    $dataTransaksi['saldo'] = $data->get('saldo');
    $dataTransaksi['proyek_id'] = proyekId();
    kasKecilLapangan::create($dataTransaksi);
    // dd($dataTransaksi);
}

function formatTanggal($date){
    $newDate = \Carbon\Carbon::parse($date);
    return $newDate->isoFormat('DD/MM/YYYY');
}
function satuanUnit($judul){
    // dd($judul);
    if($judul=='Biaya Produksi Rumah'){
        return 'm2';
    }else{
        return 'unit';
    }
}

function hitungUnit($unit,$judul,$jenis){
    $cekBlok=kavling::where('blok',$unit)->where('proyek_id',proyekId())->first();
    // dd($judul);
    if($cekBlok != null){
        if($judul=='Biaya Produksi Rumah'){
            if($jenis == 'kios' ){
                $cariKios=kios::where('kavling_id',$cekBlok->id)->where('proyek_id',proyekId())->first();
                return $cariKios->luasBangunan;

            }else{
                $cariRumah=rumah::where('kavling_id',$cekBlok->id)->where('proyek_id',proyekId())->first();
                // dd($cariRumah);
                return $cariRumah->luasBangunan;

            }
        }
    }else{
        if($jenis=='kavling'){
            $kavling = kavling::where('proyek_id',proyekId())->get();
            $hitung=$kavling->count();
            return $hitung;
        }if($jenis=='rumah'){
            $rumah = rumah::where('proyek_id',proyekId())->get();
            $hitung=$rumah->count();
            return $hitung;
        }
    }
}

function luasBangunanPelanggan($pelanggan_id){
    $luas = 0;
    while(($luas = rumah::where('pelanggan_id',$pelanggan_id)->first()) != null){
        return $luas->luasBangunan;
    }
    while(($luas = kios::where('pelanggan_id',$pelanggan_id)->first()) != null){
        return $luas->luasBangunan;
        // dd($luas);
    }
    return false;
}

function hargaSatuanRumah(){
    $satuan=1400000;
    return $satuan;
}

function hitungTransaksiRAB($idRAB){
    $total = transaksi::where('rab_id',$idRAB)->where('proyek_id',proyekId())->get();
    if($total != null){
    $totalRAB = $total->sum('debet');
        // dd($total);
        return $totalRAB;
    }else{
        return 0;
    }
}
function hitungTransaksiRABRange($idRAB,$start,$end){
    $total = transaksi::where('rab_id',$idRAB)->where('proyek_id',proyekId())->whereBetween('tanggal',[$start,$end])->get();
    if($total != null){
    $totalRAB = $total->sum('debet');
        // dd($total);
        return $totalRAB;
    }else{
        return 0;
    }
}
function hitungTransaksiRABUnit($idRAB){
    $total = transaksi::where('rabunit_id',$idRAB)->where('proyek_id',proyekId())->get();
    if($total != null){
        $totalRAB = $total->sum('debet');
        // dd($total);
        return $totalRAB;
    }else{
        return 0;
    }
}
function hitungTransaksiRABUnitRange($idRAB,$start,$end){
    $total = transaksi::where('rabunit_id',$idRAB)->where('proyek_id',proyekId())->whereBetween('tanggal',[$start,$end])->get();
    if($total != null){
        $totalRAB = $total->sum('debet');
        // dd($total);
        return $totalRAB;
    }else{
        return 0;
    }
}
function transaksiAkun($id,$start,$end){
    $transaksi =transaksi::where('akun_id',$id)->where('proyek_id',proyekId())->whereBetween('tanggal',[$start,$end])->get();
    if($transaksi != null){
        return $transaksi->sum('debet');
    }else{
        return $transaksi = 0;
    }
}
function transaksiAkunTahunan($id,$start,$end){
    $transaksi =transaksi::where('akun_id',$id)->where('proyek_id',proyekId())->whereBetween('tanggal',[$start,$end])->get();
    if($transaksi != null){
        return $transaksi->sum('debet');
    }else{
        return $transaksi = 0;
    }
}
function pendapatanLainTahunan($id,$start,$end){
    $transaksi =transaksi::where('akun_id',$id)->where('proyek_id',proyekId())->whereBetween('tanggal',[$start,$end])->get();
    if($transaksi != null){
        return $transaksi->sum('kredit');
    }else{
        return $transaksi = 0;
    }
}

function saldoBulanSebelumnya($start){
    $mulai = \Carbon\carbon::parse($start)->subMonths(1)->firstOfMonth()->isoFormat('YYYY-MM-DD');
    $akhir = \Carbon\carbon::parse($start)->subMonths(1)->endOfMonth()->isoFormat('YYYY-MM-DD');
    // $akunId=akun::where('proyek_id',proyekId())->where('namaAkun','pendapatan')->first();
    $pendapatan = transaksi::whereBetween('tanggal',[$mulai,$akhir])->where('proyek_id',proyekId())
                            ->orderBy('no','desc')->first();
    // dd($akhir);
    if($pendapatan != null){
        return $pendapatan->saldo;
    }else{
        return 0;
        // return $pendapatan->saldo;
    }
}
function saldoPettyCashBulanSebelumnya($start){
    $mulai = \Carbon\carbon::parse($start)->subMonths(1)->firstOfMonth()->isoFormat('YYYY-MM-DD');
    $akhir = \Carbon\carbon::parse($start)->subMonths(1)->endOfMonth()->isoFormat('YYYY-MM-DD');
    // $akunId=akun::where('proyek_id',proyekId())->where('namaAkun','pendapatan')->first();
    $pendapatan = pettyCash::whereBetween('tanggal',[$mulai,$akhir])->where('proyek_id',proyekId())
                            ->orderBy('no','desc')->first();
    // dd($akhir);
    if($pendapatan != null){
        return $pendapatan->saldo;
    }else{
        return 0;
        // return $pendapatan->saldo;
    }
}
function saldoPendaftaranBulanSebelumnya($start){
    $mulai = \Carbon\carbon::parse($start)->subMonths(1)->firstOfMonth()->isoFormat('YYYY-MM-DD');
    $akhir = \Carbon\carbon::parse($start)->subMonths(1)->endOfMonth()->isoFormat('YYYY-MM-DD');
    // $akunId=akun::where('proyek_id',proyekId())->where('namaAkun','pendapatan')->first();
    $pendapatan = kasPendaftaran::whereBetween('tanggal',[$mulai,$akhir])->where('proyek_id',proyekId())
                            ->orderBy('no','desc')->first();
    // dd($akhir);
    if($pendapatan != null){
        return $pendapatan->saldo;
    }else{
        return 0;
        // return $pendapatan->saldo;
    }
}
function saldoKasKecilLapanganSebelumnya($start){
    $mulai = \Carbon\carbon::parse($start)->subMonths(1)->firstOfMonth()->isoFormat('YYYY-MM-DD');
    $akhir = \Carbon\carbon::parse($start)->subMonths(1)->endOfMonth()->isoFormat('YYYY-MM-DD');
    // $akunId=akun::where('proyek_id',proyekId())->where('namaAkun','pendapatan')->first();
    $pendapatan = kasKecilLapangan::whereBetween('tanggal',[$mulai,$akhir])->where('proyek_id',proyekId())
                            ->orderBy('no','desc')->first();
    // dd($akhir);
    if($pendapatan != null){
        return $pendapatan->saldo;
    }else{
        return 0;
        // return $pendapatan->saldo;
    }
}
function biayaPembangunanRumahTahunan($start,$end){
    $akun =akun::where('jenis','Pembangunan')->where('proyek_id',proyekId())->get();
    // dd($akun);
    if($akun != null){
        $transaksiAkun=0;
        foreach($akun as $a){
            $transaksi = transaksi::where('akun_id',$a->id)->where('proyek_id',proyekId())->whereBetween('tanggal',[$start,$end])->get();
            $transaksiAkun += $transaksi->sum('debet');
        }
        return $transaksiAkun;
    }
    else{
        return 0;
    }
}
function biayaPembebananTahunan($start,$end){
    $akun =akun::where('jenis','Pembebanan')->where('proyek_id',proyekId())->get();
    // dd($akun);
    if($akun != null){
        $transaksiAkun=0;
        foreach($akun as $a){
            $transaksi = transaksi::where('akun_id',$a->id)->where('proyek_id',proyekId())->whereBetween('tanggal',[$start,$end])->get();
            $transaksiAkun += $transaksi->sum('debet');
        }
        return $transaksiAkun;
    }
    else{
        return 0;
    }
}
function penjualanTahunan($start,$end){
    $akun=akun::firstOrCreate([
        'proyek_id'=>proyekId(),
        'jenis'=>'Pendapatan',
        'kategori'=>'Pendapatan',
        'kodeAkun'=>'Pendapatan',
        'namaAkun'=>'Pendapatan',
    ]);$akun->save();
    // $akun =akun::where('namaAkun','Pendapatan')->where('proyek_id',proyekId())->first();
    if($akun != null){
        $transaksi =transaksi::where('akun_id',$akun->id)->whereBetween('tanggal',[$start,$end])->get();
        if($transaksi != null){
            return $transaksi->sum('kredit');
        }else{
            return $transaksi = 0;
        }
    }else{
        return $transaksi = 0;

    }
}
function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
    $temp = "";
    if($nilai == 0){
        $temp = $huruf[$nilai];
    }
    else if ($nilai < 12) {
        $temp = " ". $huruf[$nilai];
    } else if ($nilai <20) {
        $temp = penyebut($nilai - 10). " Belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " Seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " Seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
    }     
    return $temp;
}

function tkoma($nilai)
{
    $nilai = stristr($nilai,'.');
    $angka = array("nol", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan","sembilan");
    $temp="";
    $pjg = strlen($nilai);
    $pos = 1;

    while($pos < $pjg){
        $char = substr($nilai,$pos,1);
        $pos++;
        $temp = " ".$angka[$char];
    }
    return $temp;
}

function terbilang($nilai) {
    if($nilai<0) {
        $hasil = "minus ". trim(penyebut($nilai));
    } else {
        $poin = trim(tkoma($nilai));
        $hasil = trim(penyebut($nilai));
    }
        if($poin){
            $hasil = ucfirst ($hasil).' koma '.$poin;
        }else{
            $hasil = ucfirst($hasil);
        }
        return $hasil;  
    
}
function romawi($number) {
    $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    $returnValue = '';
    while ($number > 0) {
        foreach ($map as $roman => $int) {
            if($number >= $int) {
                $number -= $int;
                $returnValue .= $roman;
                break;
            }
        }
    }
    return $returnValue;
}

function cekGudang($transaksiId){
    $cek = gudang::where('transaksi_id',$transaksiId)->where('proyek_id',proyekId())->first();
    if($cek !=null){
        if($cek->sisa >0){
            // $this
            return "ada";
        }elseif($cek->sisa >=0){
            return "habis";
        }
    }
    return false;
    
}
function cekStatusKavling($id){
    $cek = pembelian::where("kavling_id",$id)->get()->last();
    // dd($cek);
    if($cek != null){
        return $cek->statusPembelian;
    }
    return "Ready";
}
function cekCicilanTerakhir($pembelianId){
    $pembelian = pembelian::find($pembelianId);
    return $pembelian->cicilan->last();
}
function cekDPTerbayar($DPId,$tanggal){
    $start = \Carbon\carbon::parse($tanggal)->firstOfMonth()->isoFormat('YYYY-MM-DD');
    $end = \Carbon\carbon::parse($tanggal)->endOfMonth()->isoFormat('YYYY-MM-DD');
    $cekSekarang = dp::find($DPId);
    $cekTerbayar = dp::whereBetween('tanggal',[$start,$end])->where('pelanggan_id',$cekSekarang->pelanggan->id)->get();

    if($cekTerbayar->first() != null){
        $total=0;
        foreach($cekTerbayar as $terbayar){
            $total = $total+$terbayar->jumlah;
        }
        return $total;
    }else{
        return null;
    }
}
function cekPembayaranDP($DPId){
    $cekDPIni = dp::find($DPId);
    $tempo = \Carbon\carbon::parse($cekDPIni->tempo)->firstOfMonth()->isoFormat('YYYY-MM-DD');
    $cekTerbayar = dp::where('pelanggan_id',$cekDPIni->pelanggan_id)->where('tanggal','>',$tempo)->get();
    if($cekTerbayar->first() != null){
        $pembayaranSelanjutnya= $cekTerbayar->first();
        return $pembayaranSelanjutnya->jumlah;
    }
        return null;
}
function cekDPEstimasi($DPId){
    $cekDPIni = dp::find($DPId);
    $tempo = \Carbon\carbon::parse($cekDPIni->tempo)->firstOfMonth()->isoFormat('YYYY-MM-DD');
    $cekTerbayar = dp::where('pelanggan_id',$cekDPIni->pelanggan_id)->where('tanggal','>',$tempo)->get();
    if($cekTerbayar->first() != null){
        $pembayaranSelanjutnya= $cekTerbayar->first();
        return $pembayaranSelanjutnya;
    }
        return null;
}
function cekPembayaranCicilan($cicilanId){
    $cekCicilanIni = cicilan::find($cicilanId);
    $tempo = \Carbon\carbon::parse($cekCicilanIni->tempo)->firstOfMonth()->isoFormat('YYYY-MM-DD');
    $cekTerbayar = cicilan::where('pelanggan_id',$cekCicilanIni->pelanggan_id)->where('tanggal','>',$tempo)->get();
    if($cekTerbayar->first() != null){
        $pembayaranSelanjutnya= $cekTerbayar->first();
        return $pembayaranSelanjutnya->jumlah;
    }
        return null;
}
function cekPembayaranEstimasi($cicilanId){
    $cekCicilanIni = cicilan::find($cicilanId);
    $tempo = \Carbon\carbon::parse($cekCicilanIni->tempo)->firstOfMonth()->isoFormat('YYYY-MM-DD');
    $cekTerbayar = cicilan::where('pelanggan_id',$cekCicilanIni->pelanggan_id)->where('tanggal','>',$tempo)->get();
    if($cekTerbayar->first() != null){
        $pembayaranSelanjutnya= $cekTerbayar->first();
        return $pembayaranSelanjutnya;
    }
        return null;
}
function cekTotalDp($pembelianId){
    $total = dp::where('pembelian_id',$pembelianId)->get();
    return $total->sum('jumlah');
}
function cicilanTerbayar($id,$tanggal){
    $terbayar = cicilan::where('pembelian_id',$id)->where('tanggal','<=',$tanggal)->get();
    if($terbayar){
        $total = $terbayar->sum('jumlah');
        return $total;
    }
    return 0;
}
function cicilanKe($id,$tanggal){
    $ke = cicilan::where('pembelian_id',$id)->where('tanggal','<=',$tanggal)->count();
    if($ke){
        return $ke;
    }
    return 0;
}
function filterBulan($tanggal){
    $dateMonthArray = explode('/', $tanggal);
    $month = $dateMonthArray[0];
    $year = $dateMonthArray[1];
    $tanggal = Carbon::createFromDate($year,$month)->startOfMonth()->isoFormat('MMMM YYYY');
    return $tanggal;

}