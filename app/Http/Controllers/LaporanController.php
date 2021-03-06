<?php

namespace App\Http\Controllers;

use PDF;
use App\dp;
use App\rab;
use App\akun;
use App\proyek;
use App\cicilan;
use App\rabUnit;
use SnappyImage;
use App\rekening;
use App\pembelian;
use App\pengadaan;
use App\transaksi;
use Carbon\Carbon;
use App\isiPengadaan;
use App\tambahanDetail;
use App\Exports\MasukExport;
use Illuminate\Http\Request;
use App\Exports\KeluarExport;
use App\Exports\PengadaanExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanBulananExport;
use App\Exports\LaporanTahunanExport;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function laporanBulananRAB(Request $request)
    {
        // dd($request);
        // $akunId=akun::where('proyek_id',proyekId())->where('namaAkun','pendapatan')->first();
        $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
        $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
        $tahunSebelumStart = Carbon::now()->subYears(1)->firstOfYear()->isoFormat('YYYY-MM-DD');
        $tahunSebelumEnd = Carbon::now()->subYears(1)->endOfYear()->isoFormat('YYYY-MM-DD');
        $tahuniniStart = Carbon::now()->firstOfYear()->isoFormat('YYYY-MM-DD');
        $tahuniniEnd = Carbon::now()->endOfYear()->isoFormat('YYYY-MM-DD');
        $aset = rab::where('isi', 'Aset')->where('proyek_id', proyekId())->first();
        if ($request->get('filter')) {
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $tahunSebelumStart = Carbon::parse($request->start)->subYears(1)->firstOfYear()->isoFormat('YYYY-MM-DD');
            $tahunSebelumEnd = Carbon::parse($request->end)->subYears(1)->endOfYear()->isoFormat('YYYY-MM-DD');
            $tahuniniStart = Carbon::parse($request->start)->firstOfYear()->isoFormat('YYYY-MM-DD');
            $tahuniniEnd = Carbon::parse($request->end)->endOfYear()->isoFormat('YYYY-MM-DD');
            $pendapatan = transaksi::whereIn('kategori', ['Penerimaan','Pendapatan', 'Pendapatan Lain', 'Kelebihan Tanah'])->where('tambahan',0)->where('proyek_id', proyekId())->whereBetween('tanggal', [$start, $end])->get();
            $modal = transaksi::where('kategori', 'Modal')->where('tambahan',0)->whereBetween('tanggal', [$start, $end])->where('proyek_id', proyekId())->get();
            $modalTahunSebelum = transaksi::where('kategori', 'Modal')->where('tambahan',0)->where('proyek_id', proyekId())->where('tanggal', '<=', $tahunSebelumEnd)->get();
            // dd($pendapatan->count());
            if ($modalTahunSebelum) {
                $mts = $modalTahunSebelum->sum('kredit');
            } else {
                $mts = 0;
            }
            $bulan = transaksi::where('kategori', 'Modal')->where('tambahan',0)->where('proyek_id', proyekId())->where('tanggal', '<=', $end)->whereBetween('tanggal', [$tahuniniStart, $tahuniniEnd])->get()->groupBy(function ($val) {
                return Carbon::parse($val->tanggal)->isoFormat('MMMM');
            });
            if ($aset) {
                $transaksiAset = transaksi::where('rab_id', $aset->id)->where('tambahan',0)->where('proyek_id', proyekId())->where('tanggal', '<=', $end)->whereBetween('tanggal', [$tahuniniStart, $tahuniniEnd])->get()->groupBy(function ($val) {
                    return Carbon::parse($val->tanggal)->isoFormat('MMMM');
                });
                $AsetTahunSebelum = transaksi::where('rab_id', $aset->id)->where('tambahan',0)->where('proyek_id', proyekId())->where('tanggal', '<=', $tahunSebelumEnd)->get();
                if ($AsetTahunSebelum) {
                    $ats = $AsetTahunSebelum->sum('debet');
                } else {
                    $ats = 0;
                }
            } else {
                $transaksiAset = [];
                $ats = 0;
            }
        } else {
            $pendapatan = transaksi::whereIn('kategori', ['Penerimaan','Pendapatan', 'Pendapatan Lain', 'Kelebihan Tanah'])->where('tambahan',0)->where('proyek_id', proyekId())->whereBetween('tanggal', [$start, $end])->get();
            $modal = transaksi::where('kategori', 'Modal')->where('tambahan',0)->whereBetween('tanggal', [$start, $end])->where('proyek_id', proyekId())->get();
            $modalTahunSebelum = transaksi::where('kategori', 'Modal')->where('tambahan',0)->where('proyek_id', proyekId())->where('tanggal', '<=', $tahunSebelumEnd)->get();
            if ($modalTahunSebelum) {
                $mts = $modalTahunSebelum->sum('kredit');
            } else {
                $mts = 0;
            }
            $bulan = transaksi::where('kategori', 'Modal')->where('tambahan',0)->where('tanggal', '<=', $end)->where('proyek_id', proyekId())->whereBetween('tanggal', [$tahuniniStart, $tahuniniEnd])->get()->groupBy(function ($val) {
                return Carbon::parse($val->tanggal)->isoFormat('MMMM');
            });
            // if($aset){
            //     $transaksiAset=transaksi::where('rab_id',$aset->id)->whereBetween('tanggal',[$tahuniniStart,$tahuniniEnd])->get()->groupBy(function ($val) {
            //         return Carbon::parse($val->tanggal)->isoFormat('MMMM');
            //     });
            // }
            if ($aset) {
                $transaksiAset = transaksi::where('rab_id', $aset->id)->where('tambahan',0)->where('tanggal', '<=', $end)->where('proyek_id', proyekId())->whereBetween('tanggal', [$tahuniniStart, $tahuniniEnd])->get()->groupBy(function ($val) {
                    return Carbon::parse($val->tanggal)->isoFormat('MMMM');
                });
                $AsetTahunSebelum = transaksi::where('rab_id', $aset->id)->where('tambahan',0)->where('proyek_id', proyekId())->where('tanggal', '<=', $tahunSebelumEnd)->get();
                if ($AsetTahunSebelum) {
                    $ats = $AsetTahunSebelum->sum('debet');
                } else {
                    $ats = 0;
                }
            } else {
                $transaksiAset = [];
                $ats = 0;
            }
        }
        /* RAB */
        // $a = transaksi::whereBetween('tanggal', [$start, $end])->where('kredit',null)->where('proyek_id', proyekId())->get();
        // dd($a->count());
        $semuaRAB = rab::all()->where('proyek_id', proyekId())->groupBy(['header', function ($item) {
            return $item['judul'];
        }], $preserveKeys = true);
        $semuaUnit = rabUnit::where('proyek_id', proyekId())->get()->groupBy(['header', function ($item) {
            return $item['judul'];
        }], $preserveKeys = true);

        return view('laporan/bulananRAB', compact(
            'transaksiAset',
            'ats',
            'pendapatan',
            'start',
            'end',
            'semuaRAB',
            'semuaUnit',
            'mts',
            'bulan',
            'tahuniniStart'
        ));
    }
    public function laporanTahunan(Request $request)
    {
        $start = Carbon::now()->firstOfYear()->isoFormat('YYYY-MM-DD');
        $end = Carbon::now()->endOfYear()->isoFormat('YYYY-MM-DD');
        $tahunSebelumStart = Carbon::now()->subYears(1)->firstOfYear()->isoFormat('YYYY-MM-DD');
        $tahunSebelumEnd = Carbon::now()->subYears(1)->endOfYear()->isoFormat('YYYY-MM-DD');
        $tahuniniStart = Carbon::now()->firstOfYear()->isoFormat('YYYY-MM-DD');
        $tahuniniEnd = Carbon::now()->endOfYear()->isoFormat('YYYY-MM-DD');
        $aset = rab::where('isi', 'Aset')->where('proyek_id', proyekId())->first();
        if ($request->get('filter')) {
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $tahunSebelumStart = Carbon::parse($request->start)->subYears(1)->firstOfYear()->isoFormat('YYYY-MM-DD');
            $tahunSebelumEnd = Carbon::parse($request->end)->subYears(1)->endOfYear()->isoFormat('YYYY-MM-DD');
            $tahuniniStart = Carbon::parse($request->start)->firstOfYear()->isoFormat('YYYY-MM-DD');
            $tahuniniEnd = Carbon::parse($request->end)->endOfYear()->isoFormat('YYYY-MM-DD');
            $pendapatan = transaksi::whereIn('kategori', ['Penerimaan','Pendapatan', 'Pendapatan Lain'])->where('tambahan',0)->where('proyek_id', proyekId())->whereBetween('tanggal', [$start, $end])->get();
            $modal = transaksi::where('kategori', 'Modal')->where('tambahan',0)->where('proyek_id', proyekId())->whereBetween('tanggal', [$start, $end])->get();
            $modalTahunSebelum = transaksi::where('kategori', 'Modal')->where('tambahan',0)->where('proyek_id', proyekId())->where('tanggal', '<=', $tahunSebelumEnd)->get();

            if ($modalTahunSebelum) {
                $mts = $modalTahunSebelum->sum('kredit');
            } else {
                $mts = 0;
            }
            $bulan = transaksi::where('kategori', 'Modal')->where('tambahan',0)->where('tanggal', '<=', $end)->where('proyek_id', proyekId())->whereBetween('tanggal', [$tahuniniStart, $tahuniniEnd])->get()->groupBy(function ($val) {
                return Carbon::parse($val->tanggal)->isoFormat('MMMM');
            });
            if ($aset) {
                $transaksiAset = transaksi::where('rab_id', $aset->id)->where('tambahan',0)->where('tanggal', '<=', $end)->where('proyek_id', proyekId())->whereBetween('tanggal', [$tahuniniStart, $tahuniniEnd])->get()->groupBy(function ($val) {
                    return Carbon::parse($val->tanggal)->isoFormat('MMMM');
                });
                $AsetTahunSebelum = transaksi::where('rab_id', $aset->id)->where('tambahan',0)->where('tanggal', '<=', $tahunSebelumEnd)->where('proyek_id', proyekId())->get();
                if ($AsetTahunSebelum) {
                    $ats = $AsetTahunSebelum->sum('debet');
                } else {
                    $ats = 0;
                }
            } else {
                $transaksiAset = [];
                $ats = 0;
            }
        } else {
            $pendapatan = transaksi::whereIn('kategori', ['Penerimaan','Pendapatan', 'Pendapatan Lain'])->where('tambahan',0)->where('proyek_id', proyekId())->whereBetween('tanggal', [$start, $end])->get();
            $modal = transaksi::where('kategori', 'Modal')->where('proyek_id', proyekId())->where('tambahan',0)->whereBetween('tanggal', [$start, $end])->get();
            $modalTahunSebelum = transaksi::where('kategori', 'Modal')->where('tambahan',0)->where('proyek_id', proyekId())->where('tanggal', '<=', $tahunSebelumEnd)->get();
            if ($modalTahunSebelum) {
                $mts = $modalTahunSebelum->sum('kredit');
            } else {
                $mts = 0;
            }
            $bulan = transaksi::where('kategori', 'Modal')->where('tambahan',0)->where('tanggal', '<=', $end)->where('proyek_id', proyekId())->whereBetween('tanggal', [$tahuniniStart, $tahuniniEnd])->get()->groupBy(function ($val) {
                return Carbon::parse($val->tanggal)->isoFormat('MMMM');
            });
            // if($aset){
            //     $transaksiAset=transaksi::where('rab_id',$aset->id)->whereBetween('tanggal',[$tahuniniStart,$tahuniniEnd])->get()->groupBy(function ($val) {
            //         return Carbon::parse($val->tanggal)->isoFormat('MMMM');
            //     });
            // }
            if ($aset) {
                $transaksiAset = transaksi::where('rab_id', $aset->id)->where('tambahan',0)->where('proyek_id', proyekId())->where('tanggal', '<=', $end)->whereBetween('tanggal', [$tahuniniStart, $tahuniniEnd])->get()->groupBy(function ($val) {
                    return Carbon::parse($val->tanggal)->isoFormat('MMMM');
                });
                $AsetTahunSebelum = transaksi::where('rab_id', $aset->id)->where('tambahan',0)->where('proyek_id', proyekId())->where('tanggal', '<=', $tahunSebelumEnd)->get();
                if ($AsetTahunSebelum) {
                    $ats = $AsetTahunSebelum->sum('debet');
                } else {
                    $ats = 0;
                }
            } else {
                $transaksiAset = [];
                $ats = 0;
            }
        }
        /* RAB */
        $semuaRAB = rab::all()->where('proyek_id', proyekId())->groupBy(['header', function ($item) {
            return $item['judul'];
        }], $preserveKeys = true);
        $semuaUnit = rabUnit::where('proyek_id', proyekId())->get()->groupBy(['header', function ($item) {
            return $item['judul'];
        }], $preserveKeys = true);
        return view('laporan/tahunanIndex', compact(
            'transaksiAset',
            'ats',
            'pendapatan',
            'start',
            'end',
            'semuaRAB',
            'semuaUnit',
            'mts',
            'bulan',
            'tahuniniStart'
        ));
    }
    public function cetakKwitansi(Cicilan $id)
    {
        if(auth()->user()->proyek_id != $id->proyek_id){
            return redirect()->route('pelangganIndex')->with('status',$id->pelanggan->nama .' adalah pelanggan '.$id->pelanggan->proyek->nama);
        }
        // dd($id);
        $pembayaranPertama = cicilan::where('pembelian_id', $id->pembelian_id)->orderBy('tanggal')->first();
        $pembayaranSebelum = cicilan::where('pembelian_id', $id->pembelian_id)->where('tanggal', '<', $id->tanggal)->orderBy('tanggal', 'desc')->first();
        if ($pembayaranSebelum) {
            $tempoSebelum = $pembayaranSebelum->tempo;
        } else {
            $tempoSebelum = $id->tanggal;
        }
        // dd($tempoSebelum);
        $semuaPembayaran = cicilan::where('pembelian_id', $id->pembelian_id)->where('tanggal', '<=', $id->tanggal)->get();
        $nilai = floor($id->pembelian->sisaKewajiban / $id->pembelian->tenor);
        $bulanTerbayar = intVal($semuaPembayaran->sum('jumlah') / $nilai);
        $bulanBerjalan = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->diffInMonths(Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth(), true);
        $cek = Carbon::parse($id->tanggal)->firstOfMonth()->diffInMonths(Carbon::parse($tempoSebelum)->firstOfMonth(), false);
        // dd($nilai);
        if ($cek >= 0) {
            /* lancar */
            /* pembayaran dibawah nilai bulanan */
            if ($nilai > $id->jumlah) {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->isoFormat('YYYY-MM-DD');
            } elseif ($bulanTerbayar >= $bulanBerjalan) {
                $tempo = Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth()->addMonth($bulanTerbayar)->isoFormat('YYYY-MM-DD');
            } else {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            }
        } else {
            /* nunggak */
            /* pembayaran dibawah nilai bulanan */
            if ($nilai > $id->jumlah) {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->isoFormat('YYYY-MM-DD');
            } elseif ($bulanTerbayar >= $bulanBerjalan) {
                $tempo = Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth()->addMonth($bulanTerbayar)->isoFormat('YYYY-MM-DD');
            } else {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            }
            // $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
        }
        $proyek = proyek::find(proyekId());
        $rekening = rekening::where('proyek_id', proyekId())->get();
        $pembelian = pembelian::where('id', $id->pembelian_id)->first();
        $uraian = 'Pembayaran Cicilan Ke ' . cicilanKe($id->pembelian_id, $id->tanggal) . ' ' . jenisKepemilikan($pembelian->pelanggan_id) . ' ' . $pembelian->kavling->blok;
        $cicilanPertama = cicilan::where('pembelian_id', $pembelian->id)->first();
        $sampaiSekarang = cicilan::whereBetween('created_at', [$cicilanPertama->tanggal, $id->tanggal])->where('pembelian_id', $id->pembelian_id)->get();
        $kekurangan = $nilai * bulanCicilanBerjalan($id) - cicilanTerbayar($id->pembelian_id, $id->tanggal);
        $sisaHutang = $id->pembelian->sisaKewajiban - cicilanTerbayar($id->pembelian_id, $id->tanggal);
        if ($kekurangan > $sisaHutang) {
            $kekurangan = $sisaHutang;
        } else {
            $kekurangan = $kekurangan;
        }
        // dd($kekurangan);
        return view('cetak/kwitansi', compact('kekurangan', 'tempo', 'id', 'pembelian', 'uraian', 'sampaiSekarang', 'rekening', 'proyek'));
    }
    public function cetakKwitansiDp(Dp $id)
    {
        // dd($id);
        if(auth()->user()->proyek_id != $id->proyek_id){
            return redirect()->route('pelangganIndex')->with('status',$id->pelanggan->nama .' adalah pelanggan '.$id->pelanggan->proyek->nama);
        }
        $pembayaranPertama = dp::where('pembelian_id', $id->pembelian_id)->orderBy('tanggal')->first();
        $pembayaranSebelum = dp::where('pembelian_id', $id->pembelian_id)->where('tanggal', '<', $id->tanggal)->orderBy('tanggal', 'desc')->first();
        if ($pembayaranSebelum) {
            $tempoSebelum = $pembayaranSebelum->tempo;
        } else {
            $tempoSebelum = $id->tanggal;
        }
        $semuaPembayaran = dp::where('pembelian_id', $id->pembelian_id)->where('tanggal', '<=', $id->tanggal)->get();
        $nilai = floor($id->pembelian->dp / $id->pembelian->tenorDP);
        $bulanTerbayar = intVal($semuaPembayaran->sum('jumlah') / $nilai);
        $bulanBerjalan = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->diffInMonths(Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth(), true);

        $cek = Carbon::parse($id->tanggal)->firstOfMonth()->diffInMonths(Carbon::parse($tempoSebelum)->firstOfMonth(), false);
        if ($cek >= 0) {
            /* lancar */
            if ($nilai > $id->jumlah) {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->isoFormat('YYYY-MM-DD');
            } elseif ($bulanTerbayar >= $bulanBerjalan) {
                $tempo = Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth()->addMonth($bulanTerbayar)->isoFormat('YYYY-MM-DD');
            } else {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            }
        } else {
            /* nunggak */
            if ($nilai > $id->jumlah) {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->isoFormat('YYYY-MM-DD');
            } elseif ($bulanTerbayar >= $bulanBerjalan) {
                $tempo = Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth()->addMonth($bulanTerbayar)->isoFormat('YYYY-MM-DD');
            } else {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            }
            // $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
        }
        $sisaHutang = $id->pembelian->dp - dpTerbayar($id->pembelian_id, $id->tanggal);
        $kekurangan = $nilai * bulanDpBerjalan($id) - dpTerbayar($id->pembelian_id, $id->tanggal);
        if ($kekurangan > $sisaHutang) {
            $kekurangan = $sisaHutang;
        } else {
            $kekurangan = $kekurangan;
        }
        $proyek = proyek::find(proyekId());
        $pembelian = pembelian::where('id', $id->pembelian_id)->first();
        $rekening = rekening::where('proyek_id', proyekId())->get();
        $uraian = 'Pembayaran Dp Ke ' . dpKe($id->pembelian_id, $id->tanggal) . ' ' . jenisKepemilikan($pembelian->pelanggan_id) . ' ' . $pembelian->kavling->blok;
        $DpPertama = dp::where('pembelian_id', $pembelian->id)->first();
        $sampaiSekarang = dp::whereBetween('created_at', [$DpPertama->tanggal, $id->tanggal])->where('pembelian_id', $id->pembelian_id)->get();
        // dd($sampaiSekarang->sum('jumlah'));
        return view('cetak/kwitansiDp', compact('kekurangan', 'tempo', 'id', 'pembelian', 'uraian', 'sampaiSekarang', 'rekening', 'proyek'));
    }
    public function exportBulanan(Request $request)
    {
        $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
        $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
        $tahunSebelumStart = Carbon::now()->subYears(1)->firstOfYear()->isoFormat('YYYY-MM-DD');
        $tahunSebelumEnd = Carbon::now()->subYears(1)->endOfYear()->isoFormat('YYYY-MM-DD');
        $tahuniniStart = Carbon::now()->firstOfYear()->isoFormat('YYYY-MM-DD');
        $tahuniniEnd = Carbon::now()->endOfYear()->isoFormat('YYYY-MM-DD');
        $aset = rab::where('isi', 'Aset')->where('proyek_id', proyekId())->first();
        if ($request->get('filter')) {
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $tahunSebelumStart = Carbon::parse($request->start)->subYears(1)->firstOfYear()->isoFormat('YYYY-MM-DD');
            $tahunSebelumEnd = Carbon::parse($request->end)->subYears(1)->endOfYear()->isoFormat('YYYY-MM-DD');
            $tahuniniStart = Carbon::parse($request->start)->firstOfYear()->isoFormat('YYYY-MM-DD');
            $tahuniniEnd = Carbon::parse($request->end)->endOfYear()->isoFormat('YYYY-MM-DD');
            $pendapatan = transaksi::whereIn('kategori', ['Penerimaan','Pendapatan', 'Pendapatan Lain', 'Kelebihan Tanah'])->where('tambahan',0)->where('proyek_id', proyekId())->whereBetween('tanggal', [$start, $end])->get();
            $modal = transaksi::where('kategori', 'Modal')->where('proyek_id', proyekId())->whereBetween('tanggal', [$start, $end])->get();
            $modalTahunSebelum = transaksi::where('kategori', 'Modal')->where('tambahan',0)->where('proyek_id', proyekId())->where('tanggal', '<=', $tahunSebelumEnd)->get();

            if ($modalTahunSebelum) {
                $mts = $modalTahunSebelum->sum('kredit');
            } else {
                $mts = 0;
            }
            $bulan = transaksi::where('kategori', 'Modal')->where('tambahan',0)->where('tanggal', '<=', $end)->where('proyek_id', proyekId())->whereBetween('tanggal', [$tahuniniStart, $tahuniniEnd])->get()->groupBy(function ($val) {
                return Carbon::parse($val->tanggal)->isoFormat('MMMM');
            });
            if ($aset) {
                $transaksiAset = transaksi::where('rab_id', $aset->id)->where('tambahan',0)->where('proyek_id', proyekId())->where('tanggal', '<=', $end)->whereBetween('tanggal', [$tahuniniStart, $tahuniniEnd])->get()->groupBy(function ($val) {
                    return Carbon::parse($val->tanggal)->isoFormat('MMMM');
                });
                $AsetTahunSebelum = transaksi::where('rab_id', $aset->id)->where('tambahan',0)->where('proyek_id', proyekId())->where('tanggal', '<=', $tahunSebelumEnd)->get();
                if ($AsetTahunSebelum) {
                    $ats = $AsetTahunSebelum->sum('debet');
                } else {
                    $ats = 0;
                }
            } else {
                $transaksiAset = [];
                $ats = 0;
            }
        } else {
            $pendapatan = transaksi::whereIn('kategori', ['Penerimaan','Pendapatan', 'Pendapatan Lain', 'Kelebihan Tanah'])->where('tambahan',0)->where('proyek_id', proyekId())->whereBetween('tanggal', [$start, $end])->get();
            $modal = transaksi::where('kategori', 'Modal')->where('tambahan',0)->where('proyek_id', proyekId())->whereBetween('tanggal', [$start, $end])->get();
            $modalTahunSebelum = transaksi::where('kategori', 'Modal')->where('tambahan',0)->where('proyek_id', proyekId())->where('tanggal', '<=', $tahunSebelumEnd)->get();
            if ($modalTahunSebelum) {
                $mts = $modalTahunSebelum->sum('kredit');
            } else {
                $mts = 0;
            }
            $bulan = transaksi::where('kategori', 'Modal')->where('tambahan',0)->where('tanggal', '<=', $end)->where('proyek_id', proyekId())->whereBetween('tanggal', [$tahuniniStart, $tahuniniEnd])->get()->groupBy(function ($val) {
                return Carbon::parse($val->tanggal)->isoFormat('MMMM');
            });
            // if($aset){
            //     $transaksiAset=transaksi::where('rab_id',$aset->id)->whereBetween('tanggal',[$tahuniniStart,$tahuniniEnd])->where('tanggal','<',$start)->get()->groupBy(function ($val) {
            //         return Carbon::parse($val->tanggal)->isoFormat('MMMM');
            //     });
            // }
            if ($aset) {
                $transaksiAset = transaksi::where('rab_id', $aset->id)->where('tambahan',0)->where('proyek_id', proyekId())->where('tanggal', '<=', $end)->whereBetween('tanggal', [$tahuniniStart, $tahuniniEnd])->get()->groupBy(function ($val) {
                    return Carbon::parse($val->tanggal)->isoFormat('MMMM');
                });
                $AsetTahunSebelum = transaksi::where('rab_id', $aset->id)->where('tambahan',0)->where('proyek_id', proyekId())->where('tanggal', '<=', $tahunSebelumEnd)->get();
                if ($AsetTahunSebelum) {
                    $ats = $AsetTahunSebelum->sum('debet');
                } else {
                    $ats = 0;
                }
            } else {
                $transaksiAset = [];
                $ats = 0;
            }
        }
        // dd($pendapatan->first());
        /* RAB */
        $semuaRAB = rab::all()->where('proyek_id', proyekId())->groupBy(['header', function ($item) {
            return $item['judul'];
        }], $preserveKeys = true);
        $semuaUnit = rabUnit::where('proyek_id', proyekId())->get()->groupBy(['header', function ($item) {
            return $item['judul'];
        }], $preserveKeys = true);
        return Excel::download(new LaporanBulananExport(
            $transaksiAset,
            $ats,
            $pendapatan,
            $start,
            $end,
            $mts,
            $bulan,
            $tahuniniStart,
            $semuaRAB,
            $semuaUnit
        ), 'LaporanBulanan.xlsx');
    }
    public function exportTahunan(Request $request)
    {
        $start = Carbon::now()->firstOfYear()->isoFormat('YYYY-MM-DD');
        $end = Carbon::now()->endOfYear()->isoFormat('YYYY-MM-DD');
        $tahunSebelumStart = Carbon::now()->subYears(1)->firstOfYear()->isoFormat('YYYY-MM-DD');
        $tahunSebelumEnd = Carbon::now()->subYears(1)->endOfYear()->isoFormat('YYYY-MM-DD');
        $tahuniniStart = Carbon::now()->firstOfYear()->isoFormat('YYYY-MM-DD');
        $tahuniniEnd = Carbon::now()->endOfYear()->isoFormat('YYYY-MM-DD');
        $aset = rab::where('isi', 'Aset')->where('proyek_id', proyekId())->first();
        if ($request->get('filter')) {
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $tahunSebelumStart = Carbon::parse($request->start)->subYears(1)->firstOfYear()->isoFormat('YYYY-MM-DD');
            $tahunSebelumEnd = Carbon::parse($request->end)->subYears(1)->endOfYear()->isoFormat('YYYY-MM-DD');
            $tahuniniStart = Carbon::parse($request->start)->firstOfYear()->isoFormat('YYYY-MM-DD');
            $tahuniniEnd = Carbon::parse($request->end)->endOfYear()->isoFormat('YYYY-MM-DD');
            $pendapatan = transaksi::whereIn('kategori', ['Penerimaan','Pendapatan', 'Pendapatan Lain'])->where('tambahan',0)->where('proyek_id', proyekId())->whereBetween('tanggal', [$start, $end])->get();
            $modal = transaksi::where('kategori', 'Modal')->where('tambahan',0)->where('proyek_id', proyekId())->whereBetween('tanggal', [$start, $end])->get();
            $modalTahunSebelum = transaksi::where('kategori', 'Modal')->where('tambahan',0)->where('proyek_id', proyekId())->where('tanggal', '<=', $tahunSebelumEnd)->get();

            if ($modalTahunSebelum) {
                $mts = $modalTahunSebelum->sum('kredit');
            } else {
                $mts = 0;
            }
            $bulan = transaksi::where('kategori', 'Modal')->where('tambahan',0)->where('tanggal', '<=', $end)->where('proyek_id', proyekId())->whereBetween('tanggal', [$tahuniniStart, $tahuniniEnd])->get()->groupBy(function ($val) {
                return Carbon::parse($val->tanggal)->isoFormat('MMMM');
            });
            if ($aset) {
                $transaksiAset = transaksi::where('rab_id', $aset->id)->where('tambahan',0)->where('tanggal', '<=', $end)->where('proyek_id', proyekId())->whereBetween('tanggal', [$tahuniniStart, $tahuniniEnd])->get()->groupBy(function ($val) {
                    return Carbon::parse($val->tanggal)->isoFormat('MMMM');
                });
                $AsetTahunSebelum = transaksi::where('rab_id', $aset->id)->where('tambahan',0)->where('proyek_id', proyekId())->where('tanggal', '<=', $tahunSebelumEnd)->get();
                if ($AsetTahunSebelum) {
                    $ats = $AsetTahunSebelum->sum('debet');
                } else {
                    $ats = 0;
                }
            } else {
                $transaksiAset = [];
                $ats = 0;
            }
        } else {
            $pendapatan = transaksi::whereIn('kategori', ['Penerimaan','Pendapatan', 'Pendapatan Lain'])->where('tambahan',0)->where('proyek_id', proyekId())->whereBetween('tanggal', [$start, $end])->get();
            $modal = transaksi::where('kategori', 'Modal')->where('tambahan',0)->where('proyek_id', proyekId())->whereBetween('tanggal', [$start, $end])->get();
            $modalTahunSebelum = transaksi::where('kategori', 'Modal')->where('tambahan',0)->where('proyek_id', proyekId())->where('tanggal', '<=', $tahunSebelumEnd)->get();
            if ($modalTahunSebelum) {
                $mts = $modalTahunSebelum->sum('kredit');
            } else {
                $mts = 0;
            }
            $bulan = transaksi::where('kategori', 'Modal')->where('tambahan',0)->where('tanggal', '<=', $end)->where('proyek_id', proyekId())->whereBetween('tanggal', [$tahuniniStart, $tahuniniEnd])->get()->groupBy(function ($val) {
                return Carbon::parse($val->tanggal)->isoFormat('MMMM');
            });
            if ($aset) {
                $transaksiAset = transaksi::where('rab_id', $aset->id)->where('tambahan',0)->where('proyek_id', proyekId())->where('tanggal', '<=', $end)->whereBetween('tanggal', [$tahuniniStart, $tahuniniEnd])->get()->groupBy(function ($val) {
                    return Carbon::parse($val->tanggal)->isoFormat('MMMM');
                });
                $AsetTahunSebelum = transaksi::where('rab_id', $aset->id)->where('tambahan',0)->where('proyek_id', proyekId())->where('tanggal', '<=', $tahunSebelumEnd)->get();
                if ($AsetTahunSebelum) {
                    $ats = $AsetTahunSebelum->sum('debet');
                } else {
                    $ats = 0;
                }
            } else {
                $transaksiAset = [];
                $ats = 0;
            }
        }
        /* RAB */
        $semuaRAB = rab::all()->where('proyek_id', proyekId())->groupBy(['header', function ($item) {
            return $item['judul'];
        }], $preserveKeys = true);
        $semuaUnit = rabUnit::where('proyek_id', proyekId())->get()->groupBy(['header', function ($item) {
            return $item['judul'];
        }], $preserveKeys = true);
        return Excel::download(new LaporanTahunanExport(
            $transaksiAset,
            $ats,
            $pendapatan,
            $start,
            $end,
            $mts,
            $bulan,
            $tahuniniStart,
            $semuaRAB,
            $semuaUnit
        ), 'LaporanTahunan.xlsx'); // return view ('laporan/tahunanIndex',compact('produksi','operasional','nonOperasional','start','end','pendapatanLain'));
    }
    public function cetakDPPDF(Dp $id)
    {
        $proyek = proyek::find(proyekId());
        // $logoPT = Storage::url($proyek->logoPT);
        // dd($logoPT);
        $pembayaranPertama = dp::where('pembelian_id', $id->pembelian_id)->orderBy('tanggal')->first();
        $pembayaranSebelum = dp::where('pembelian_id', $id->pembelian_id)->where('tanggal', '<', $id->tanggal)->orderBy('tanggal', 'desc')->first();
        if ($pembayaranSebelum) {
            $tempoSebelum = $pembayaranSebelum->tempo;
        } else {
            $tempoSebelum = $id->tanggal;
        }
        $semuaPembayaran = dp::where('pembelian_id', $id->pembelian_id)->where('tanggal', '<=', $id->tanggal)->get();
        $nilai = floor($id->pembelian->dp / $id->pembelian->tenorDP);
        $bulanTerbayar = intVal($semuaPembayaran->sum('jumlah') / $nilai);
        $bulanBerjalan = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->diffInMonths(Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth(), true);

        $cek = Carbon::parse($id->tanggal)->firstOfMonth()->diffInMonths(Carbon::parse($tempoSebelum)->firstOfMonth(), false);
        if ($cek >= 0) {
            /* lancar */
            if ($nilai > $id->jumlah) {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->isoFormat('YYYY-MM-DD');
            } elseif ($bulanTerbayar >= $bulanBerjalan) {
                $tempo = Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth()->addMonth($bulanTerbayar)->isoFormat('YYYY-MM-DD');
            } else {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            }
        } else {
            /* nunggak */
            if ($nilai > $id->jumlah) {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->isoFormat('YYYY-MM-DD');
            } elseif ($bulanTerbayar >= $bulanBerjalan) {
                $tempo = Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth()->addMonth($bulanTerbayar)->isoFormat('YYYY-MM-DD');
            } else {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            }
            // $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
        }
        $rekening = rekening::where('proyek_id', proyekId())->get();
        $pembelian = pembelian::where('id', $id->pembelian_id)->first();
        $kavling = $pembelian->pelanggan->kavling;
        if ($kavling) {
            $blok = $kavling->blok;
        } else {
            $blok = "Batal Akad";
        }
        $sisaHutang = $id->pembelian->dp - dpTerbayar($id->pembelian_id, $id->tanggal);
        $kekurangan = $nilai * bulanDpBerjalan($id) - dpTerbayar($id->pembelian_id, $id->tanggal);
        if ($kekurangan > $sisaHutang) {
            $kekurangan = $sisaHutang;
        } else {
            $kekurangan = $kekurangan;
        }
        $uraian = 'Pembayaran Dp Ke ' . dpKe($id->pembelian_id, $id->tanggal) . ' ' . jenisKepemilikan($pembelian->pelanggan_id) . ' ' . $pembelian->kavling->blok;
        $DpPertama = Dp::where('pembelian_id', $pembelian->id)->first();
        $sampaiSekarang = dp::whereBetween('created_at', [$DpPertama->tanggal, $id->tanggal])->where('pembelian_id', $id->pembelian_id)->get();
        // return view('PDF/kwitansiDp2',compact('id','pembelian','uraian','sampaiSekarang','rekening','proyek'));
        $pdf = PDF::loadview('PDF/kwitansiDP2', compact('kekurangan', 'tempo', 'id', 'pembelian', 'uraian', 'sampaiSekarang', 'rekening', 'proyek'))->setPaper('A5', 'landscape');
        return $pdf->download('Kwitansi DP ' . $pembelian->pelanggan->nama . ' ' . $blok . ' Ke ' . dpKe($id->pembelian_id, $id->tanggal) . '.pdf');
    }
    public function cetakKwitansiPDF(Cicilan $id)
    {
        // dd($id);
        $pembayaranPertama = cicilan::where('pembelian_id', $id->pembelian_id)->orderBy('tanggal')->first();
        $pembayaranSebelum = cicilan::where('pembelian_id', $id->pembelian_id)->where('tanggal', '<', $id->tanggal)->orderBy('tanggal', 'desc')->first();
        if ($pembayaranSebelum) {
            $tempoSebelum = $pembayaranSebelum->tempo;
        } else {
            $tempoSebelum = $id->tanggal;
        }
        // dd($tempoSebelum);
        $semuaPembayaran = cicilan::where('pembelian_id', $id->pembelian_id)->where('tanggal', '<=', $id->tanggal)->get();
        $nilai = floor($id->pembelian->sisaKewajiban / $id->pembelian->tenor);
        $bulanTerbayar = intVal($semuaPembayaran->sum('jumlah') / $nilai);
        $bulanBerjalan = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->diffInMonths(Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth(), true);
        $cek = Carbon::parse($id->tanggal)->firstOfMonth()->diffInMonths(Carbon::parse($tempoSebelum)->firstOfMonth(), false);
        // dd($nilai);
        if ($cek >= 0) {
            /* lancar */
            /* pembayaran dibawah nilai bulanan */
            if ($nilai > $id->jumlah) {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->isoFormat('YYYY-MM-DD');
            } elseif ($bulanTerbayar >= $bulanBerjalan) {
                $tempo = Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth()->addMonth($bulanTerbayar)->isoFormat('YYYY-MM-DD');
            } else {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            }
        } else {
            /* nunggak */
            /* pembayaran dibawah nilai bulanan */
            if ($nilai > $id->jumlah) {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->isoFormat('YYYY-MM-DD');
            } elseif ($bulanTerbayar >= $bulanBerjalan) {
                $tempo = Carbon::parse($pembayaranPertama->tanggal)->firstOfMonth()->addMonth($bulanTerbayar)->isoFormat('YYYY-MM-DD');
            } else {
                $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
            }
            // $tempo = Carbon::parse($id->tanggal)->firstOfMonth()->addMonth(1)->isoFormat('YYYY-MM-DD');
        }
        $proyek = proyek::find(proyekId());
        $logoPT = Storage::url($proyek->logoPT);
        // dd($logoPT); 
        $rekening = rekening::where('proyek_id', proyekId())->get();
        $pembelian = pembelian::where('id', $id->pembelian_id)->first();
        $kavling = $pembelian->pelanggan->kavling;
        if ($kavling) {
            $blok = $kavling->blok;
        } else {
            $blok = "Batal Akad";
        }
        $kekurangan = $nilai * bulanCicilanBerjalan($id) - cicilanTerbayar($id->pembelian_id, $id->tanggal);
        $sisaHutang = $id->pembelian->sisaKewajiban - cicilanTerbayar($id->pembelian_id, $id->tanggal);
        if ($kekurangan > $sisaHutang) {
            $kekurangan = $sisaHutang;
        } else {
            $kekurangan = $kekurangan;
        }
        $cicilanKe = cicilanKe($id->pembelian_id, $id->tanggal);
        // dd($cicilanKe);
        $uraian = 'Pembayaran Cicilan Ke ' . cicilanKe($id->pembelian_id, $id->tanggal) . ' ' . jenisKepemilikan($pembelian->pelanggan_id) . ' ' . $pembelian->kavling->blok;
        $cicilanPertama = cicilan::where('pembelian_id', $pembelian->id)->first();
        $sampaiSekarang = cicilan::whereBetween('created_at', [$cicilanPertama->tanggal, $id->tanggal])->where('pembelian_id', $id->pembelian_id)->get();
        $pdf = PDF::loadview('PDF/kwitansi', compact('kekurangan', 'tempo', 'id', 'pembelian', 'uraian', 'sampaiSekarang', 'rekening', 'proyek', 'logoPT'))->setPaper('A5', 'landscape');
        return $pdf->download('Kwitansi Cicilan ' . $pembelian->pelanggan->nama . ' ' . $blok . ' Ke ' . $cicilanKe . '.pdf');
    }
    public function exportKeluar(Request $request)
    {
        // dd($request);
        if ($request->get('filter')) {
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $transaksiKeluar = transaksi::whereBetween('tanggal', [$start, $end])->where('tambahan',0)
                ->whereNotNull('debet')->where('proyek_id', proyekId())->orderBy('tanggal')->get();
        } else {
            $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
            $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
            $transaksiKeluar = transaksi::whereBetween('tanggal', [$start, $end])->where('tambahan',0)
                ->whereNotNull('debet')->where('proyek_id', proyekId())->orderBy('tanggal')->get();
        }
        return Excel::download(new KeluarExport($transaksiKeluar, $start, $end), 'Transaksi Keluar ' . $start . '.xlsx');
    }
    public function exportMasuk(Request $request)
    {
        // dd($request);
        if ($request->get('filter')) {
            $start = Carbon::parse($request->start)->isoFormat('YYYY-MM-DD');
            $end = Carbon::parse($request->end)->isoFormat('YYYY-MM-DD');
            $transaksiMasuk = transaksi::whereBetween('tanggal', [$start, $end])->where('tambahan',0)
                ->whereNotNull('kredit')->where('proyek_id', proyekId())->orderBy('tanggal')->get();
        } else {
            $start = Carbon::now()->firstOfMonth()->isoFormat('YYYY-MM-DD');
            $end = Carbon::now()->endOfMonth()->isoFormat('YYYY-MM-DD');
            $transaksiMasuk = transaksi::whereBetween('tanggal', [$start, $end])->where('tambahan',0)
                ->whereNotNull('kredit')->where('proyek_id', proyekId())->orderBy('tanggal')->get();
        }
        return Excel::download(new MasukExport($transaksiMasuk, $start, $end), 'Transaksi Masuk ' . $start . '.xlsx');
    }
    public function cetakKwitansiTambahan(tambahanDetail $id)
    {
        if(auth()->user()->proyek_id != $id->proyek_id){
            return redirect()->route('pelangganIndex')->with('status',$id->pelanggan->nama .' adalah pelanggan '.$id->pelanggan->proyek->nama);
        }
        // dd($id->tambahan);
        $pembelian = $id->pembelian;
        $proyek = proyek::find($id->proyek_id);
        $rekening = rekening::where('proyek_id', proyekId())->get();
        return view('cetak/kwitansiTambahan', compact('id','pembelian','proyek','rekening'));
    }
    public function cetakKwitansiTambahanPDF(tambahanDetail $id)
    {
        
        // dd($id);
        $pembelian = $id->pembelian;
        $proyek = proyek::find($id->proyek_id);
        $logoPT = Storage::url($proyek->logoPT);
        $rekening = rekening::where('proyek_id', proyekId())->get();
        // return view('PDF/kwitansiTambahan', compact('id','pembelian','proyek','rekening','logoPT'));
        $pdf = PDF::loadview('PDF/kwitansiTambahan', compact('id','pembelian','proyek','rekening', 'logoPT'))->setPaper('A5', 'landscape');
        return $pdf->download('Kwitansi Pembayaran Tambahan '.$id->tambahan->keterangan.' '. $id->tambahan->pelanggan->nama . '.pdf');
    }
    public function exportIsiPengadaan(Pengadaan $id)
    {
        $semuaIsi = isiPengadaan::where('pengadaan_id',$id->id)->get();
        // dd($semuaIsi);
        return Excel::download(new PengadaanExport($id,$semuaIsi), 'Isi Pengadaan ' . $id->deskripsi . '.xlsx');
    }

}
