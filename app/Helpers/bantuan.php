<?php

use App\dp;
use App\rab;
use App\akun;
use App\kios;
use App\rumah;
use App\gudang;
use App\proyek;
use App\cicilan;
use App\kavling;
use App\rabUnit;
use App\tambahan;
use App\pelanggan;
use App\pembelian;
use App\pettyCash;
use App\transaksi;
use Carbon\Carbon;
use App\detailUser;
use App\kasPendaftaran;
use App\kasKecilLapangan;
use Illuminate\Support\Facades\DB;

function cekNamaUser()
{
    return auth()->user()->name;
}
function detailUser($id)
{
    $detail = detailUser::where('user_id', $id)->first();
    if ($detail != null) {
        return $detail;
    }
    return null;
}
function proyekId()
{

    return auth()->user()->proyek_id;
}
function listProyek()
{
    $proyek = proyek::all();
    return $proyek;
}
function namaProyek()
{
    $proyek = proyek::find(proyekId());
    return $proyek->nama;
}

function unitPelanggan($id)
{
    $unit = kavling::find($id);
    return $unit;
}

function pembelianPelanggan($id)
{
    $pembelian = pembelian::where('pelanggan_id', $id)->first();
    return ($pembelian);
}

function jenisKepemilikan($id)
{  /* $id = pelanggan_id */
    $pembelian = pembelian::where('pelanggan_id', $id)->first();
    // dd($pembelian);
    if ($pembelian->rumah_id != null) {
        return 'Rumah';
    } elseif ($pembelian->kios_id != null) {
        return 'Kios';
    } elseif ($pembelian->kavling_id != null) {
        return 'Kavling';
    }
}
function saldoTerakhir()
{
    $transaksi = DB::table('transaksi')->select('kredit', 'debet')->where('proyek_id', proyekId())->where('tanggal','<',Carbon::now()->isoFormat('YYYY-MM-DD'));
    // dd($transaksi->last());
    $saldo = $transaksi->sum('kredit') - $transaksi->sum('debet');
    return $saldo;
}
function noTransaksiTerakhir()
{
    $no = transaksi::orderBy('no', 'desc')->where('proyek_id', proyekId())->where('tambahan',0)->first();
    $noTerakhir = 0;
    if ($no != null) {
        $noTerakhir = $no->no;
    }
    return $noTerakhir;
}
function noKasKecilLapanganTerakhir()
{
    $no = kasKecilLapangan::orderBy('no', 'desc')->where('proyek_id', proyekId())->first();
    $noTerakhir = 0;
    if ($no != null) {
        $noTerakhir = $no->no;
    }
    return $noTerakhir;
}
function noPettyCashTerakhir()
{
    $no = pettycash::orderBy('no', 'desc')->where('proyek_id', proyekId())->first();
    $noTerakhir = 0;
    if ($no != null) {
        $noTerakhir = $no->no;
    }
    return $noTerakhir;
}
function totalKasBesar($start, $end)
{
    $total = transaksi::whereBetween('tanggal', [$start, $end])->where('tambahan',0)->where('proyek_id', proyekId())->orderBy('no')->get();
    if ($total != null) {
        $terakhir = $total->last();
        if ($terakhir != null) {
            return $terakhir->saldo;
        } else {
            return 0;
        }
    }
    return 0;
    // dd($total);
}
function totalKasPendaftaran($start, $end)
{
    $total = kasPendaftaran::whereBetween('tanggal', [$start, $end])->where('proyek_id', proyekId())->orderBy('no')->get();
    if ($total != null) {
        $terakhir = $total->last();
        if ($terakhir != null) {
            return $terakhir->saldo;
        } else {
            return 0;
        }
    }
    return 0;
    // dd($total);
}
function totalKasKecilLapangan($start, $end)
{
    $total = kasKecilLapangan::whereBetween('tanggal', [$start, $end])->where('proyek_id', proyekId())->orderBy('no')->get();
    if ($total != null) {
        $terakhir = $total->last();
        if ($terakhir != null) {
            return $terakhir->saldo;
        } else {
            return 0;
        }
    }
    return 0;
    // dd($total);
}
function totalPettyCash($start, $end)
{
    $total = pettyCash::whereBetween('tanggal', [$start, $end])->where('proyek_id', proyekId())->orderBy('no')->get();
    if ($total != null) {
        $terakhir = $total->last();
        if ($terakhir != null) {
            return $terakhir->saldo;
        } else {
            return 0;
        }
    }
    return 0;
    // dd($total);
}
function saldoTerakhirKasPendaftaran()
{
    $saldo = kasPendaftaran::orderBy('no', 'desc')->where('proyek_id', proyekId())->first();
    $saldoTerakhir = 0;
    if ($saldo != null) {
        $saldoTerakhir = $saldo->saldo;
    }
    return $saldoTerakhir;
}
function saldoTerakhirKasKecilLapangan()
{
    $saldo = kasKecilLapangan::orderBy('no', 'desc')->where('proyek_id', proyekId())->first();
    $saldoTerakhir = 0;
    if ($saldo != null) {
        $saldoTerakhir = $saldo->saldo;
    }
    return $saldoTerakhir;
}
function saldoTerakhirPettyCash()
{
    $saldo = pettyCash::orderBy('no', 'desc')->where('proyek_id', proyekId())->first();
    $saldoTerakhir = 0;
    if ($saldo != null) {
        $saldoTerakhir = $saldo->saldo;
    }
    return $saldoTerakhir;
}
function kasBesarMasuk($dataArray)
{
    $data = collect($dataArray);
    // $akunPendapatan=akun::firstOrCreate([
    //     'proyek_id'=>proyekId(),
    //     'jenis'=>'Pendapatan',
    //     'kategori'=>'Pendapatan',
    //     'kodeAkun'=>'Pendapatan',
    //     'namaAkun'=>'Pendapatan',
    // ]);
    $requestData = $data->all();
    $requestData['kredit'] = $data->get('kredit');
    $requestData['saldo'] = $data->get('saldo');
    $requestData['kategori'] = 'Pendapatan';
    // $requestData['akun_id']=$akunPendapatan->id;
    $requestData['proyek_id'] = proyekId();
    // dd($requestData);
    transaksi::create($requestData);
    // return $this; 
}
function saldoSebelumnya($tanggalSekarang)
{
    $transaksi = transaksi::where('tanggal', '<=', $tanggalSekarang)->where('tambahan',0)->where('proyek_id', proyekId())->orderBy('tanggal')->get();
    if ($transaksi != null) {
        $terakhir = $transaksi->last();
        return $terakhir->saldo;
    } else {
        return 0;
    }
}
function kasBesarKeluar($dataArray)
{
    $data = collect($dataArray);
    $jumlah = str_replace(',', '', $data->get('jumlah'));
    $hargaSatuan = str_replace(',', '', $data->get('hargaSatuan'));
    $total = str_replace(',', '', $data->get('total'));
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
    // $dataTransaksi['tambahan'] =$data->get('tambahan');
    // dd($dataTransaksi);
    transaksi::create($dataTransaksi);
}
function kasBesarKeluarTanpaJumlah($dataArray)
{
    $data = collect($dataArray);
    $total = str_replace(',', '', $data->get('total'));
    $dataTransaksi['tanggal'] = $data->get('tanggal');
    $dataTransaksi['satuan'] = $data->get('satuan');
    $dataTransaksi['rab_id'] = $data->get('rab_id');
    $dataTransaksi['rabunit_id'] = $data->get('rabunit_id');
    $dataTransaksi['akun_id'] = $data->get('akun_id');
    $dataTransaksi['uraian'] = $data->get('uraian');
    $dataTransaksi['sumber'] = $data->get('sumber');
    $dataTransaksi['debet'] = $total;
    $dataTransaksi['no'] = $data->get('no');
    $dataTransaksi['saldo'] = $data->get('saldo');
    $dataTransaksi['proyek_id'] = proyekId();
    // dd($dataTransaksi);
    transaksi::create($dataTransaksi);
}
function pettyCashKeluar($dataArray)
{
    $data = collect($dataArray);
    $jumlah = str_replace(',', '', $data->get('jumlah'));
    $hargaSatuan = str_replace(',', '', $data->get('hargaSatuan'));
    $total = str_replace(',', '', $data->get('total'));
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
    $jumlah = str_replace(',', '', $data->get('jumlah'));
    $hargaSatuan = str_replace(',', '', $data->get('hargaSatuan'));
    $total = str_replace(',', '', $data->get('total'));
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

function formatTanggal($date)
{
    $newDate = \Carbon\Carbon::parse($date);
    return $newDate->isoFormat('DD/MM/YYYY');
}
function formatBulanTahun($date)
{
    $newDate = \Carbon\Carbon::parse($date);
    return $newDate->isoFormat('MMMM YYYY');
}
function satuanUnit($judul)
{
    // dd($judul);
    if ($judul == 'Biaya Produksi Rumah') {
        return 'm2';
    } else {
        return 'unit';
    }
}

function hitungUnit($unit, $judul, $jenis)
{
    $cekBlok = kavling::where('blok', $unit)->where('proyek_id', proyekId())->first();
    // dd($judul);
    if ($cekBlok != null) {
        if ($judul == 'Biaya Produksi Rumah') {
            if ($jenis == 'kios') {
                $cariKios = kios::where('kavling_id', $cekBlok->id)->where('proyek_id', proyekId())->first();
                return $cariKios->luasBangunan;
            } else {
                $cariRumah = rumah::where('kavling_id', $cekBlok->id)->where('proyek_id', proyekId())->first();
                // dd($cariRumah);
                return $cariRumah->luasBangunan;
            }
        }
    } else {
        if ($jenis == 'kavling') {
            $kavling = kavling::where('proyek_id', proyekId())->get();
            $hitung = $kavling->count();
            return $hitung;
        }
        if ($jenis == 'rumah') {
            $rumah = rumah::where('proyek_id', proyekId())->get();
            $hitung = $rumah->count();
            return $hitung;
        }
    }
}

function luasBangunanPelanggan($pelanggan_id)
{
    $luas = 0;
    while (($luas = rumah::where('pelanggan_id', $pelanggan_id)->first()) != null) {
        return $luas->luasBangunan;
    }
    while (($luas = kios::where('pelanggan_id', $pelanggan_id)->first()) != null) {
        return $luas->luasBangunan;
        // dd($luas);
    }
    return false;
}

function hargaSatuanRumah()
{
    $satuan = 1400000;
    return $satuan;
}

function hitungTransaksiRAB($idRAB)
{
    $total = transaksi::where('rab_id', $idRAB)->where('tambahan',0)->where('proyek_id', proyekId())->get();
    if ($total != null) {
        $totalRAB = $total->sum('debet');
        // dd($total);
        return $totalRAB;
    } else {
        return 0;
    }
}
function hitungTransaksiRABTambahan($idRAB)
{
    $total = transaksi::where('rab_id', $idRAB)->where('tambahan',1)->where('proyek_id', proyekId())->get();
    if ($total != null) {
        $totalRAB = $total->sum('debet');
        // dd($total);
        return $totalRAB;
    } else {
        return 0;
    }
}
function hitungTransaksiRABRange($idRAB, $start, $end)
{
    $total = transaksi::where('rab_id', $idRAB)->where('tambahan',0)->where('proyek_id', proyekId())->whereBetween('tanggal', [$start, $end])->get();
    if ($total != null) {
        $totalRAB = $total->sum('debet');
        // dd($total);
        return $totalRAB;
    } else {
        return 0;
    }
}
function hitungJudulRAB($judul, $start, $end)
{
    $rab = rab::where('judul', $judul)->where('proyek_id', proyekId())->get();
    $total = 0;
    if ($rab->first()) {
        foreach ($rab as $r) {
            $total += transaksi::where('rab_id', $r->id)->where('tambahan',0)->whereBetween('tanggal', [$start, $end])->get()->sum('debet');
        }
    }
    return $total;
}
function hitungTransaksiRABUnit($idRAB)
{
    $total = transaksi::where('rabunit_id', $idRAB)->where('tambahan',0)->where('proyek_id', proyekId())->get();
    if ($total != null) {
        $totalRAB = $total->sum('debet');
        // dd($total);
        return $totalRAB;
    } else {
        return 0;
    }
}
function hitungTransaksiRABTambahanUnit($idRAB)
{
    $total = transaksi::where('rabunit_id', $idRAB)->where('tambahan',1)->where('proyek_id', proyekId())->get();
    if ($total != null) {
        $totalRAB = $total->sum('debet');
        // dd($total);
        return $totalRAB;
    } else {
        return 0;
    }
}
function hitungTransaksiRABUnitRange($idRAB, $start, $end)
{
    $total = transaksi::where('rabunit_id', $idRAB)->where('tambahan',0)->where('proyek_id', proyekId())->whereBetween('tanggal', [$start, $end])->get();
    if ($total != null) {
        $totalRAB = $total->sum('debet');
        // dd($total);
        return $totalRAB;
    } else {
        return 0;
    }
}
function transaksiAkun($id, $start, $end)
{
    $transaksi = transaksi::where('akun_id', $id)->where('tambahan',0)->where('proyek_id', proyekId())->whereBetween('tanggal', [$start, $end])->get();
    if ($transaksi != null) {
        return $transaksi->sum('debet');
    } else {
        return $transaksi = 0;
    }
}
function transaksiAkunTahunan($id, $start, $end)
{
    $transaksi = transaksi::where('akun_id', $id)->where('tambahan',0)->where('proyek_id', proyekId())->whereBetween('tanggal', [$start, $end])->get();
    if ($transaksi != null) {
        return $transaksi->sum('debet');
    } else {
        return $transaksi = 0;
    }
}
function pendapatanLainTahunan($id, $start, $end)
{
    $transaksi = transaksi::where('akun_id', $id)->where('tambahan',0)->where('proyek_id', proyekId())->whereBetween('tanggal', [$start, $end])->get();
    if ($transaksi != null) {
        return $transaksi->sum('kredit');
    } else {
        return $transaksi = 0;
    }
}

function saldoBulanSebelumnya($start)
{
    $transaksi = transaksi::where('tanggal', '<', $start)->where('tambahan',0)->where('proyek_id', proyekId())->get();
    $saldoSebelum = $transaksi->sum('kredit') - $transaksi->sum('debet');
    return $saldoSebelum;
}
function saldoPettyCashBulanSebelumnya($start)
{
    $mulai = \Carbon\carbon::parse($start)->subMonths(1)->firstOfMonth()->isoFormat('YYYY-MM-DD');
    $akhir = \Carbon\carbon::parse($start)->subMonths(1)->endOfMonth()->isoFormat('YYYY-MM-DD');
    // $akunId=akun::where('proyek_id',proyekId())->where('namaAkun','pendapatan')->first();
    $pendapatan = pettyCash::whereBetween('tanggal', [$mulai, $akhir])->where('proyek_id', proyekId())
        ->orderBy('no', 'desc')->first();
    // dd($akhir);
    if ($pendapatan != null) {
        return $pendapatan->saldo;
    } else {
        return 0;
        // return $pendapatan->saldo;
    }
}
function saldoPendaftaranBulanSebelumnya($start)
{
    $mulai = \Carbon\carbon::parse($start)->subMonths(1)->firstOfMonth()->isoFormat('YYYY-MM-DD');
    $akhir = \Carbon\carbon::parse($start)->subMonths(1)->endOfMonth()->isoFormat('YYYY-MM-DD');
    // $akunId=akun::where('proyek_id',proyekId())->where('namaAkun','pendapatan')->first();
    $pendapatan = kasPendaftaran::whereBetween('tanggal', [$mulai, $akhir])->where('proyek_id', proyekId())
        ->orderBy('no', 'desc')->first();
    // dd($akhir);
    if ($pendapatan != null) {
        return $pendapatan->saldo;
    } else {
        return 0;
        // return $pendapatan->saldo;
    }
}
function saldoKasKecilLapanganSebelumnya($start)
{
    $mulai = \Carbon\carbon::parse($start)->subMonths(1)->firstOfMonth()->isoFormat('YYYY-MM-DD');
    $akhir = \Carbon\carbon::parse($start)->subMonths(1)->endOfMonth()->isoFormat('YYYY-MM-DD');
    // $akunId=akun::where('proyek_id',proyekId())->where('namaAkun','pendapatan')->first();
    $pendapatan = kasKecilLapangan::whereBetween('tanggal', [$mulai, $akhir])->where('proyek_id', proyekId())
        ->orderBy('no', 'desc')->first();
    // dd($akhir);
    if ($pendapatan != null) {
        return $pendapatan->saldo;
    } else {
        return 0;
        // return $pendapatan->saldo;
    }
}
function biayaPembangunanRumahTahunan($start, $end)
{
    $akun = akun::where('jenis', 'Pembangunan')->where('proyek_id', proyekId())->get();
    // dd($akun);
    if ($akun != null) {
        $transaksiAkun = 0;
        foreach ($akun as $a) {
            $transaksi = transaksi::where('akun_id', $a->id)->where('tambahan',0)->where('proyek_id', proyekId())->whereBetween('tanggal', [$start, $end])->get();
            $transaksiAkun += $transaksi->sum('debet');
        }
        return $transaksiAkun;
    } else {
        return 0;
    }
}
function biayaPembebananTahunan($start, $end)
{
    $akun = akun::where('jenis', 'Pembebanan')->where('proyek_id', proyekId())->get();
    // dd($akun);
    if ($akun != null) {
        $transaksiAkun = 0;
        foreach ($akun as $a) {
            $transaksi = transaksi::where('akun_id', $a->id)->where('tambahan',0)->where('proyek_id', proyekId())->whereBetween('tanggal', [$start, $end])->get();
            $transaksiAkun += $transaksi->sum('debet');
        }
        return $transaksiAkun;
    } else {
        return 0;
    }
}
function penjualanTahunan($start, $end)
{
    $akun = akun::firstOrCreate([
        'proyek_id' => proyekId(),
        'jenis' => 'Pendapatan',
        'kategori' => 'Pendapatan',
        'kodeAkun' => 'Pendapatan',
        'namaAkun' => 'Pendapatan',
    ]);
    $akun->save();
    // $akun =akun::where('namaAkun','Pendapatan')->where('proyek_id',proyekId())->first();
    if ($akun != null) {
        $transaksi = transaksi::where('akun_id', $akun->id)->where('tambahan',0)->whereBetween('tanggal', [$start, $end])->get();
        if ($transaksi != null) {
            return $transaksi->sum('kredit');
        } else {
            return $transaksi = 0;
        }
    } else {
        return $transaksi = 0;
    }
}
function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
    $temp = "";
    if ($nilai == 0) {
        $temp = $huruf[$nilai];
    } else if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " Belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " Puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " Seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " Ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " Seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " Ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " Juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " Milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " Trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function tkoma($nilai)
{
    $nilai = stristr($nilai, '.');
    $angka = array("nol", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan");
    $temp = "";
    $pjg = strlen($nilai);
    $pos = 1;

    while ($pos < $pjg) {
        $char = substr($nilai, $pos, 1);
        $pos++;
        $temp = " " . $angka[$char];
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = "minus " . trim(penyebut($nilai));
    } else {
        $poin = trim(tkoma($nilai));
        $hasil = trim(penyebut($nilai));
    }
    if ($poin) {
        $hasil = ucfirst($hasil) . ' koma ' . $poin;
    } else {
        $hasil = ucfirst($hasil);
    }
    return $hasil;
}
function romawi($number)
{
    $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    $returnValue = '';
    while ($number > 0) {
        foreach ($map as $roman => $int) {
            if ($number >= $int) {
                $number -= $int;
                $returnValue .= $roman;
                break;
            }
        }
    }
    return $returnValue;
}

function cekGudang($transaksiId)
{
    $cek = gudang::where('transaksi_id', $transaksiId)->where('proyek_id', proyekId())->first();
    if ($cek != null) {
        if ($cek->sisa > 0) {
            // $this
            return "ada";
        } elseif ($cek->sisa >= 0) {
            return "habis";
        }
    }
    return false;
}
function cekStatusKavling($id)
{
    $cek = pembelian::where("kavling_id", $id)->get()->last();
    // dd($cek);
    if ($cek != null) {
        return $cek->statusPembelian;
    }
    return "Ready";
}
function cekCicilanTerakhir($pembelianId)
{
    $pembelian = pembelian::find($pembelianId);
    return $pembelian->cicilan->last();
}
function cekDPTerbayar($DPId, $tanggal)
{
    $start = \Carbon\carbon::parse($tanggal)->firstOfMonth()->isoFormat('YYYY-MM-DD');
    $end = \Carbon\carbon::parse($tanggal)->endOfMonth()->isoFormat('YYYY-MM-DD');
    $cekSekarang = dp::find($DPId);
    $cekTerbayar = dp::whereBetween('tanggal', [$start, $end])->where('pelanggan_id', $cekSekarang->pelanggan->id)->get();

    if ($cekTerbayar->first() != null) {
        $total = 0;
        foreach ($cekTerbayar as $terbayar) {
            $total = $total + $terbayar->jumlah;
        }
        return $total;
    } else {
        return null;
    }
}
function cekDPNunggakBulanIni(Pembelian $id, $tanggal)
{
    $start = \Carbon\carbon::parse($tanggal)->firstOfMonth()->isoFormat('YYYY-MM-DD');
    $end = \Carbon\carbon::parse($tanggal)->endOfMonth();
    $dp = $id->dp()->orderBy('tanggal')->get();
    $tempoSebelum = $dp->where('tempo', '<=', $end)->last();
    $pembayaranSetelah = $dp->where('tanggal', '>', $end)->first();
    $tempoSetelah = $dp->where('tempo', '>', $end)->first();
    $tempoBulanIni = $dp->whereBetween('tempo', [$start, $end])->first();
    $pembayaranBulanIni = $dp->whereBetween('tanggal', [$start, $end])->first();
    $terbayar = dp::where('pembelian_id', $id->id)->where('tanggal', '<=', $end)->orderBy('tanggal')->get();
    $terbayarSebelum = $terbayar->sum('jumlah');
    $pembayaranPertama = dp::where('pembelian_id', $id->id)->orderBy('tanggal')->first();
    if ($pembayaranPertama) {
        $berjalan = Carbon::parse($tanggal)->endOfMonth()->addDay(2)->diffInMonths(Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth(), true);
    } else {
        $berjalan = 0;
    }
    $seharusnya = $berjalan * ($id->dp / $id->tenorDP);
    // return $seharusnya;
    if ($pembayaranBulanIni == null) {
        /* tidak ada pembayaran bulan ini */
        if ($terbayarSebelum < $seharusnya) {
            if ($tempoBulanIni != null || $tempoSebelum != null && $tempoSetelah == null) {
                /* ada tempo, dan tidak ada tempo setelah */
                return $dp;
            }
        }
    }
    return null;
}
function cekCicilanNunggakBulanIni(Pembelian $id, $tanggal)
{
    $start = \Carbon\carbon::parse($tanggal)->firstOfMonth()->isoFormat('YYYY-MM-DD');
    $end = \Carbon\carbon::parse($tanggal)->endOfMonth();
    $cicilan = $id->cicilan->sortBy('tanggal');
    $tempoSebelum = $cicilan->where('tempo', '<=', $end)->last();
    $pembayaranSetelah = $cicilan->where('tanggal', '>', $end)->first();
    $tempoSetelah = $cicilan->where('tempo', '>', $end)->first();
    $tempoBulanIni = $cicilan->whereBetween('tempo', [$start, $end])->first();
    $pembayaranBulanIni = $cicilan->whereBetween('tanggal', [$start, $end])->first();
    $terbayar = cicilan::where('pembelian_id', $id->id)->where('tanggal', '<=', $end)->orderBy('tanggal')->get();
    $terbayarSebelum = $terbayar->sum('jumlah');
    $pembayaranPertama = cicilan::where('pembelian_id', $id->id)->orderBy('tanggal')->first();
    if ($pembayaranPertama) {
        $berjalan = Carbon::parse($tanggal)->endOfMonth()->addDay(2)->diffInMonths(Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth(), true);
    } else {
        $berjalan = 0;
    }
    $seharusnya = $berjalan * ($id->sisaKewajiban / $id->tenor);
    if ($pembayaranBulanIni == null) {
        /* tidak ada pembayaran bulan ini */
        if ($terbayarSebelum < $seharusnya) {
            if ($tempoBulanIni != null || $tempoSebelum != null && $tempoSetelah == null) {
                return $cicilan;
            }
        }
    }
    return null;
}
function cekPembayaranDP($DPId)
{
    $cekDPIni = dp::find($DPId);
    $tempo = \Carbon\carbon::parse($cekDPIni->tempo)->firstOfMonth()->isoFormat('YYYY-MM-DD');
    $cekTerbayar = dp::where('pelanggan_id', $cekDPIni->pelanggan_id)->where('tanggal', '>', $cekDPIni->tanggal)->get();
    if ($cekTerbayar->first() != null) {

        return $pembayaranSelanjutnya = $cekTerbayar->sum('jumlah');
        //  $pembayaranSelanjutnya->jumlah;
    }
    return null;
}
function cekDPEstimasi($DPId)
{
    $cekDPIni = dp::find($DPId);
    $tempo = \Carbon\carbon::parse($cekDPIni->tempo)->firstOfMonth()->isoFormat('YYYY-MM-DD');
    $cekTerbayar = dp::where('pelanggan_id', $cekDPIni->pelanggan_id)->where('tanggal', '>', $cekDPIni->tanggal)->get();
    if ($cekTerbayar->first() != null) {
        $pembayaranSelanjutnya = $cekTerbayar->first();
        return $pembayaranSelanjutnya;
    }
    return null;
}
function cekPembayaranCicilan($cicilanId)
{
    $cekCicilanIni = cicilan::find($cicilanId);
    $tempo = \Carbon\carbon::parse($cekCicilanIni->tempo)->firstOfMonth()->isoFormat('YYYY-MM-DD');
    $cekTerbayar = cicilan::where('pelanggan_id', $cekCicilanIni->pelanggan_id)->where('tanggal', '>', $cekCicilanIni->tanggal)->get();
    if ($cekTerbayar->first() != null) {
        return $pembayaranSelanjutnya = $cekTerbayar->sum('jumlah');
        // return $pembayaranSelanjutnya->jumlah;
    }
    return null;
}
function cekPembayaranEstimasi($cicilanId)
{
    $cekCicilanIni = cicilan::find($cicilanId);
    $tempo = \Carbon\carbon::parse($cekCicilanIni->tempo)->firstOfMonth()->isoFormat('YYYY-MM-DD');
    $cekTerbayar = cicilan::where('pelanggan_id', $cekCicilanIni->pelanggan_id)->where('tanggal', '>', $cekCicilanIni->tanggal)->where('tanggal', '>=', $tempo)->get();
    if ($cekTerbayar->first() != null) {
        $pembayaranSelanjutnya = $cekTerbayar->first();
        return $pembayaranSelanjutnya;
    }
    return null;
}
function cekTotalDp($pembelianId)
{
    $total = dp::where('pembelian_id', $pembelianId)->get();
    return $total->sum('jumlah');
}
function cicilanTerbayar($id, $tanggal)
{
    $terbayar = cicilan::where('pembelian_id', $id)->where('tanggal', '<=', $tanggal)->get();
    if ($terbayar) {
        $total = $terbayar->sum('jumlah');
        return $total;
    }
    return 0;
}
function cicilanKe($id, $tanggal)
{
    $ke = cicilan::where('pembelian_id', $id)->where('tanggal', '<=', $tanggal)->count();
    if ($ke) {
        return $ke;
    }
    return 0;
}
function dpTerbayar($id, $tanggal)
{
    $terbayar = dp::where('pembelian_id', $id)->where('tanggal', '<=', $tanggal)->get();
    if ($terbayar) {
        $total = $terbayar->sum('jumlah');
        return $total;
    }
    return 0;
}
function dpKe($id, $tanggal)
{
    $ke = dp::where('pembelian_id', $id)->where('tanggal', '<=', $tanggal)->count();
    if ($ke) {
        return $ke;
    }
    return 0;
}
function filterBulan($tanggal)
{
    $dateMonthArray = explode('/', $tanggal);
    $month = $dateMonthArray[0];
    $year = $dateMonthArray[1];
    $tanggal = Carbon::createFromDate($year, $month)->startOfMonth()->isoFormat('MMMM YYYY');
    return $tanggal;
}
function updateDPPelanggan(pembelian $dp)
{
    $semuaDp = $dp->dp()->get();
    foreach ($semuaDp as $a) {
        updateTempo($a);
        // updateSisaDp($a);
    }
    return true;
}
function updateCicilanPelanggan(pembelian $cicilan)
{
    $semuaCicilan = $cicilan->cicilan()->get();
    foreach ($semuaCicilan as $a) {
        updateTempoCicilan($a);
        updateSisaCicilan($a);
    }
    return true;
}

function updateTempo(dp $id)
{
    $pembayaranPertama = dp::where('pembelian_id', $id->pembelian_id)->orderBy('tanggal')->first();
    $pembayaranSebelum = dp::where('pembelian_id', $id->pembelian_id)->where('tanggal', '<', $id->tanggal)->orderBy('tanggal', 'desc')->first();
    if ($pembayaranSebelum) {
        $tempoSebelum = $pembayaranSebelum->tempo;
    } else {
        $tempoSebelum = $id->tanggal;
    }
    $semuaPembayaran = dp::where('pembelian_id', $id->pembelian_id)->where('tanggal', '<=', $id->tanggal)->get();
    $nilai = $id->pembelian->dp / $id->pembelian->tenorDP;
    $bulanTerbayar = intVal($semuaPembayaran->sum('jumlah') / $nilai);
    // $bulanBerjalan = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->diffInMonths(Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth(),true);
    $bulanBerjalan = Carbon::parse($id->tanggal)->endOfMonth()->addDay(2)->diffInMonths(Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth(), true);
    $cek = Carbon::parse($id->tanggal)->firstOfMonth()->diffInMonths(Carbon::parse($tempoSebelum)->firstOfMonth(), false);
    if ($cek >= 0) {
        /* lancar */
        if ($bulanTerbayar >= $bulanBerjalan) {
            $tempo = Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth()->addMonth($bulanTerbayar)->isoFormat('YYYY-MM-DD');
        } else {
            if ($nilai > $id->jumlah) {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            } else {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            }
        }
    } else {
        /* nunggak */
        if ($bulanTerbayar >= $bulanBerjalan) {
            $tempo = Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth()->addMonth($bulanTerbayar)->isoFormat('YYYY-MM-DD');
        } else {
            if ($nilai > $id->jumlah) {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            } else {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            }
        }
    }
    if ($id->pembelian->dp - dpTerbayar($id->pembelian->id, $id->tanggal) <= 0) {
        /* lunas dp */
        $tempoCicilanPertama = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
        $id->update(['tempo' => $tempoCicilanPertama]);
    } else {
        $id->update(['tempo' => $tempo]);
    }
    // return true;
}
function updateTempoCicilan(cicilan $id)
{
    $pembayaranPertama = cicilan::where('pembelian_id', $id->pembelian_id)->orderBy('tanggal')->first();
    $pembayaranSebelum = cicilan::where('pembelian_id', $id->pembelian_id)->where('tanggal', '<', $id->tanggal)->orderBy('tanggal', 'desc')->first();
    if ($pembayaranSebelum) {
        $tempoSebelum = $pembayaranSebelum->tempo;
    } else {
        $tempoSebelum = $id->tanggal;
    }
    $semuaPembayaran = cicilan::where('pembelian_id', $id->pembelian_id)->where('tanggal', '<=', $id->tanggal)->get();
    $nilai = $id->pembelian->sisaKewajiban / $id->pembelian->tenor;
    $bulanTerbayar = intVal($semuaPembayaran->sum('jumlah') / $nilai);
    // $bulanBerjalan = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->diffInMonths(Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth(),true);
    $bulanBerjalan = Carbon::parse($id->tanggal)->endOfMonth()->addDay(2)->diffInMonths(Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth(), true);

    $cek = Carbon::parse($id->tanggal)->firstOfMonth()->diffInMonths(Carbon::parse($tempoSebelum)->firstOfMonth(), false);
    if ($cek >= 0) {
        /* lancar */
        if ($bulanTerbayar >= $bulanBerjalan) {
            $tempo = Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth()->addMonth($bulanTerbayar)->isoFormat('YYYY-MM-DD');
        } else {
            if ($nilai > $id->jumlah) {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            } else {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            }
        }
    } else {
        /* nunggak */
        if ($bulanTerbayar >= $bulanBerjalan) {
            $tempo = Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth()->addMonth($bulanTerbayar)->isoFormat('YYYY-MM-DD');
        } else {
            if ($nilai > $id->jumlah) {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            } else {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            }
        }
        // $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
    }
    $id->update(['tempo' => $tempo]);
}

function totalDpKavling()
{
    $pembelianKavling = pembelian::whereNull('rumah_id')->whereNull('kios_id')->get();
    $totalTerbayar = 0;
    foreach ($pembelianKavling as $p) {
        $totalTerbayar += $p->dp()->sum('jumlah');
    }
    return $totalTerbayar;
    // $totalDP = $pembelianKavling->sum('dp');
    // $totalTerbayar = $totalDP - 
    // dd($pembelianKavling->sum('dp'));
}
function sisaDpKavling()
{
    $pembelianKavling = pembelian::whereNull('rumah_id')->whereNull('kios_id')->get();
    $sisa = $pembelianKavling->sum('dp') - totalDpKavling();
    // dd($sisa);
    return $sisa;
}
function cicilanTerbayarTotal($id)
{
    $sisa = cicilan::where('pembelian_id', $id)->get();
    if ($sisa) {
        return $sisa->sum('jumlah');
    }
    return 0;
}
function updateSisaDp(Dp $id)
{
    $akadDp = $id->pembelian->dp;
    $sisa = $akadDp - dpTerbayar($id->pembelian_id, $id->tanggal);
    $id->update(['sisaDp' => $sisa]);
}
function updateSisaCicilan(Cicilan $id)
{
    $akad = $id->pembelian->sisaKewajiban;
    $sisa = $akad - cicilanTerbayar($id->pembelian_id, $id->tanggal);
    $id->update(['sisaKewajiban' => $sisa]);
}
function bulanCicilanBerjalan(Cicilan $id)
{
    $pembayaranPertama = cicilan::where('pembelian_id', $id->pembelian_id)->orderBy('tanggal')->first();
    $berjalan = Carbon::parse($id->tanggal)->endOfMonth()->addDay(2)->diffInMonths(Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth(), true);
    // dd($berjalan);
    return $berjalan;
}
function bulanDpBerjalan(dp $id)
{
    $pembayaranPertama = dp::where('pembelian_id', $id->pembelian_id)->orderBy('tanggal')->first();
    $berjalan = Carbon::parse($id->tanggal)->endOfMonth()->addDay(2)->diffInMonths(Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth(), true);
    return $berjalan;
}
function saldoTransaksiSebelum2($no)
{
    $sebelum = transaksi::where('no', $no - 1)->where('tambahan',0)->first();
    $sekarang = transaksi::where('no', $no)->where('tambahan',0)->first();
    return $sebelum->kredit - $sebelum->debet;
}
function saldoTransaksiSebelum3($no)
{
    $sebelum = transaksi::where('no', $no - 1)->where('tambahan',0)->first();
    $sekarang = transaksi::where('no', $no)->where('tambahan',0)->first();
    return $sebelum->kredit - $sebelum->debet;
}
function bulanCicilanTunggakanBerjalan(Cicilan $id, $tanggal)
{
    $pembayaranPertama = cicilan::where('pembelian_id', $id->pembelian_id)->orderBy('tanggal')->first();
    $sampaiSekarang = cicilan::where('tempo', '<=', Carbon::parse($tanggal)->endOfMonth())->orderBy('tanggal')->get();
    $berjalan = Carbon::parse($sampaiSekarang->last()->tempo)->endOfMonth()->addDay(2)->diffInMonths(Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth(), true);
    $terbayar = cicilan::where('pembelian_id', $id->pembelian_id)->where('tempo', '<=', Carbon::parse($sampaiSekarang->last()->tempo)->endOfMonth())->sum('jumlah');
    $nilai = $id->pembelian->sisaKewajiban / $id->pembelian->tenor;
    $seharusnyaTerbayar = $nilai * $berjalan;
    $tunggakan = $seharusnyaTerbayar - $terbayar;
    return $tunggakan;
}
function bulanDpTunggakanBerjalan(dp $id, $tanggal)
{
    $pembayaranPertama = dp::where('pembelian_id', $id->pembelian_id)->orderBy('tanggal')->first();
    $sampaiSekarang = dp::where('tempo', '<=', Carbon::parse($tanggal)->endOfMonth())->orderBy('tanggal')->get();
    $berjalan = Carbon::parse($sampaiSekarang->last()->tempo)->endOfMonth()->addDay(2)->diffInMonths(Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth(), true);
    $terbayar = dp::where('pembelian_id', $id->pembelian_id)->where('tempo', '<=', Carbon::parse($sampaiSekarang->last()->tempo)->endOfMonth())->sum('jumlah');
    $nilai = $id->pembelian->dp / $id->pembelian->tenorDP;
    $seharusnyaTerbayar = $nilai * $berjalan;
    $tunggakan = $seharusnyaTerbayar - $terbayar;
    return $tunggakan;
}
function tempoDpNunggak(Pembelian $id, $start)
{
    $dp = $id->dp()->orderBy('tanggal')->where('tempo', '<=', Carbon::parse($start)->endOfMonth())->get();
    return $dp->last();
}
function tempoCicilanNunggak(Pembelian $id, $start)
{
    $cicilan = $id->cicilan->sortBy('tanggal')->where('tempo', '<=', Carbon::parse($start)->endOfMonth());
    return $cicilan->last();
}
function cekCicilanBulananTerbayar(Pembelian $id, $tanggal)
{
    $cek = cicilan::where('pembelian_id', $id->id)
        ->whereBetween('tanggal', [Carbon::parse($tanggal)->firstOfMonth(), Carbon::parse($tanggal)->endOfMonth()])
        ->get();
    if ($cek) {
        return $cek;
    }
    return null;
}
function cekCicilanBulananSelanjutnya(Pembelian $id, $tanggal)
{
    $cek = cicilan::where('pembelian_id', $id->id)
        ->where('tanggal', '>=', Carbon::parse($tanggal)->firstOfMonth()->addMonth(1))
        ->get();
    if ($cek) {
        return $cek;
    }
    return null;
}
function cekDpBulananSelanjutnya(Pembelian $id, $tanggal)
{
    $cek = dp::where('pembelian_id', $id->id)
        ->where('tanggal', '>=', Carbon::parse($tanggal)->firstOfMonth()->addMonth(1))
        ->get();
    if ($cek) {
        return $cek;
    }
    return null;
}
function cekTempoDpBulananSelanjutnya(Pembelian $id, $tanggal)
{
    $cek = dp::where('pembelian_id', $id->id)
        ->where('tempo', '>=', Carbon::parse($tanggal)->firstOfMonth()->addMonth(1))
        ->get();
    if ($cek) {
        return $cek;
    }
    return null;
}
function cekCicilanBulananTempo(Pembelian $id, $tanggal)
{
    $cek = cicilan::where('pembelian_id', $id->id)
        ->whereBetween('tempo', [Carbon::parse($tanggal)->firstOfMonth(), Carbon::parse($tanggal)->endOfMonth()])
        ->get();
    if ($cek) {
        return $cek->last();
    }
    return null;
}
function cekDpBulananTempo(Pembelian $id, $tanggal)
{
    $cek = dp::where('pembelian_id', $id->id)
        ->whereBetween('tempo', [Carbon::parse($tanggal)->firstOfMonth(), Carbon::parse($tanggal)->endOfMonth()])
        ->get();
    if ($cek) {
        return $cek->last();
    }
    return null;
}
function pembayaranCicilanEstimasi(Pembelian $id, $tanggal)
{
    $terbayar = cicilan::where('pembelian_id', $id->id)->where('tanggal', '<=', Carbon::parse($tanggal)->endOfMonth())->orderBy('tanggal')->get();
    $terbayarSebelum = $terbayar->sum('jumlah');
    $pembayaranPertama = cicilan::where('pembelian_id', $id->id)->orderBy('tanggal')->first();
    if ($pembayaranPertama) {
        $berjalan = Carbon::parse($tanggal)->endOfMonth()->addDay(2)->diffInMonths(Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth(), true);
    } else {
        $berjalan = 0;
    }
    $seharusnya = $berjalan * floor($id->sisaKewajiban / $id->tenor);

    if (cekCicilanBulananTerbayar($id, $tanggal)->sum('jumlah') == 0 && cekCicilanBulananSelanjutnya($id, $tanggal) != null) {
        /* jika bulan ini blm bayar dan bulan depan ada bayaran */
        if (cekCicilanBulananTempo($id, $tanggal) == null) {
            /* jika tidak ada tempo dibulan ini */
            if (cekCicilanSekaligus($id, $tanggal)) {
                /* berarti dia ngebomb bayar di bulan sebelumnya */
                return cekCicilanSekaligus($id, $tanggal)->tempo;
            }
        } elseif ($terbayarSebelum >= $seharusnya) {
            /* jika jatuh tempo sudah terbayar di bulan sebelumnya */
            $tempo = cicilan::where('pembelian_id', $id->id)->where('tanggal', '<', Carbon::parse($tanggal)->firstOfMonth())->where('tempo', '>=', Carbon::parse($tanggal)->firstOfMonth())->get();
            // return $tempo;
            if ($tempo->last()) {
                $tempoTerakhir = $tempo->last();
                return $tempoTerakhir->tempo;
            }
        } else {
            /* berarti bulan ini blm bayar */
            return null;
        }
    } else {
        /* nominal saldo pembayaran bulan ini */
        return cekCicilanBulananTerbayar($id, $tanggal)->sum('jumlah');
    }
}
function pembayaranDpEstimasi(Pembelian $id, $tanggal)
{
    $terbayar = dp::where('pembelian_id', $id->id)->where('tanggal', '<=', Carbon::parse($tanggal)->endOfMonth())->orderBy('tanggal')->get();
    $terbayarSebelum = $terbayar->sum('jumlah');
    $pembayaranPertama = dp::where('pembelian_id', $id->id)->orderBy('tanggal')->first();
    if ($pembayaranPertama) {
        $berjalan = Carbon::parse($tanggal)->endOfMonth()->addDay(2)->diffInMonths(Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth(), true);
    } else {
        $berjalan = 0;
    }
    // return $terbayarSebelum;
    $seharusnya = $berjalan * floor($id->dp / $id->tenorDP);
    // return $seharusnya;
    if (cekDpBulananTerbayar($id, $tanggal)->sum('jumlah') == 0 && cekDpBulananSelanjutnya($id, $tanggal) != null) {
        /* jika bulan ini blm bayar dan bulan depan ada bayaran */
        if (cekDpBulananTempo($id, $tanggal) == null) {
            /* jika tidak ada tempo dibulan ini */
            if (cekDpSekaligus($id, $tanggal)) {
                /* berarti dia ngebomb bayar di bulan sebelumnya */
                return cekDpSekaligus($id, $tanggal)->tempo;
            }
        } elseif ($terbayarSebelum >= $seharusnya) {
            /* jika jatuh tempo sudah terbayar di bulan sebelumnya */
            $tempo = dp::where('pembelian_id', $id->id)->where('tanggal', '<', Carbon::parse($tanggal)->firstOfMonth())->where('tempo', '>=', Carbon::parse($tanggal)->firstOfMonth())->get();
            // return $tempo;
            if ($tempo->last()) {
                $tempoTerakhir = $tempo->last();
                return $tempoTerakhir->tempo;
            }
        } else {
            /* berarti bulan ini blm bayar */
            return null;
        }
    } else {
        /* nominal saldo pembayaran bulan ini */
        return cekDpBulananTerbayar($id, $tanggal)->sum('jumlah');
    }
}

function cekDpBulananTerbayar(Pembelian $id, $tanggal)
{
    $cek = dp::where('pembelian_id', $id->id)
        ->whereBetween('tanggal', [Carbon::parse($tanggal)->firstOfMonth(), Carbon::parse($tanggal)->endOfMonth()])
        ->get();

    if ($cek) {
        return $cek;
    }
    return null;
}
function cekDpTanggalTerbayar(Pembelian $id, $tanggal)
{
    $cek = dp::where('pembelian_id', $id->id)
        ->whereBetween('tanggal', [Carbon::parse($tanggal)->firstOfMonth(), Carbon::parse($tanggal)->endOfMonth()])
        ->get();
    if ($cek) {
        return $cek->last();
    }
    return null;
}
function cekCicilanSekaligus(Pembelian $id, $tanggal)
{
    $cek = cicilan::where('pembelian_id', $id->id)
        ->where('tempo', '>', Carbon::parse($tanggal)->firstOfMonth())
        ->orderBy('tanggal')
        ->get();
    if ($cek) {
        return $cek->last();
    }
    return null;
}
function cekDpSekaligus(Pembelian $id, $tanggal)
{
    $cek = dp::where('pembelian_id', $id->id)
        ->where('tempo', '>', Carbon::parse($tanggal)->firstOfMonth())
        ->orderBy('tanggal')
        ->get();
    if ($cek) {
        return $cek->last();
    }
    return null;
}
function cekDPLunasBulanan(pembelian $id, $tanggal)
{
    $awalBulan = Carbon::parse($tanggal)->endOfMonth();
    $akhirBulan = Carbon::parse($tanggal)->endOfMonth();
    $cek = dp::where('pembelian_id', $id->id)
        ->where('tanggal', '<=', $akhirBulan)
        ->orderBy('tanggal')
        ->get();
    if ($cek->last()) {
        if ($cek->last()->sisaDp === 0 && $cek->last()->tempo <= $awalBulan) {
            return "lunas";
        }
        return "Cicilan";
    }
}
function transaksiRAB($judul)
{
    $rab = rab::where('judul', $judul)->get();
    $total = 0;
    foreach ($rab as $r) {
        $transaksi = transaksi::where('rab_id', $r->id)->where('tambahan',0)->get();
        $total += $transaksi->sum('debet');
    }
    return $total;
}
function transaksiRABTambahan($judul)
{
    $rab = rab::where('judul', $judul)->get();
    $total = 0;
    foreach ($rab as $r) {
        $transaksi = transaksi::where('rab_id', $r->id)->where('tambahan',1)->get();
        $total += $transaksi->sum('debet');
    }
    return $total;
}
function transaksiRABUnit($judul)
{
    $rab = rabUnit::where('judul', $judul)->get();
    $total = 0;
    foreach ($rab as $r) {
        $transaksi = transaksi::where('rabunit_id', $r->id)->where('tambahan',0)->get();
        $total += $transaksi->sum('debet');
    }
    return $total;
}
function transaksiRABUnitTambahan($judul)
{
    $rab = rabUnit::where('judul', $judul)->get();
    $total = 0;
    foreach ($rab as $r) {
        $transaksi = transaksi::where('rabunit_id', $r->id)->where('tambahan',1)->get();
        $total += $transaksi->sum('debet');
    }
    return $total;
}
function hitungDetailTambahan($id)
{
    $tambahan = tambahan::findOrFail($id);
    if($tambahan->tambahanDetail != null){
        $tambahanDetail = $tambahan->tambahanDetail()->get();
        $total = $tambahanDetail->sum('jumlah');
    }else{
        $tambahanDetail = [];
        $total =0;
    }
    return $total;
}