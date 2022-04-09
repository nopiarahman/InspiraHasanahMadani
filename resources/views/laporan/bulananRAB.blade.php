@extends('layouts.tema')
@section('menuLaporanBulanan', 'active')
@section('menuLaporan', 'active')
@section('content')
    <div class="section-header">
        <div class="container">

            <div class="row">
                <div class="col-6">
                    <h1>Laporan Keuangan Bulanan</h1>
                </div>
                <div class="col-6">
                    {{-- filter --}}
                    <form action="{{ route('exportBulanan') }}" method="get" enctype="multipart/form-data">
                        <div class="form-group row mb-4">
                            <div class="input-group col-sm-12 col-md-12">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <input type="text" id="reportrange2"
                                    class="form-control filter @error('filter') is-invalid @enderror" name="filter"
                                    value="{{ request('filter') }}" id="filter">
                                <input type="hidden" name="start" id="mulai2" value="{{ $start }}">
                                <input type="hidden" name="end" id="akhir2" value="{{ $end }}">
                                <button type="submit" class="btn btn-primary btn-icon icon-right">
                                    <i class="fas fa-file-excel    "></i>
                                    Export
                                </button>
                            </div>
                    </form>
                    <script type="text/javascript">
                        $(function() {
                            moment.locale('id');
                            var start = moment($('#mulai2').val());
                            var end = moment($('#akhir2').val());

                            function cb(start, end) {
                                $('#reportrange2 span').html(start.format('D M Y') + ' - ' + end.format('DD MMMM YYYY'));
                                $('#mulai2').val(start);
                                $('#akhir2').val(end);
                            }
                            $('#reportrange2').daterangepicker({
                                startDate: start,
                                endDate: end,
                                ranges: {
                                    '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                                    'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                                    'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                                        'month').endOf('month')]
                                }
                            }, cb);
                        });
                    </script>
                    {{-- end filter --}}
                </div>
            </div>
        </div>
    </div>
    </div>
    {{-- filter tanggal --}}
    <div class="card my-n3">
        <div class="section mt-4 mr-3 ">
            {{-- filter --}}
            <form action="{{ route('laporanBulanan') }}" method="get" enctype="multipart/form-data">

                <div class="form-group row ">
                    <div class="input-group col-sm-12 col-md-12">
                        <label class="col-form-label text-md-right col-12 col-md-6 col-lg-6 "> <span
                                style="font-size:small">Pilih Tanggal: </span> </label>
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                            </div>
                        </div>
                        <input type="text" id="reportrange"
                            class="form-control filter @error('filter') is-invalid @enderror" name="filter"
                            value="{{ request('filter') }}" id="filter">
                        <input type="hidden" name="start" id="mulai" value="{{ $start }}">
                        <input type="hidden" name="end" id="akhir" value="{{ $end }}">
                        <button type="submit" class="btn btn-primary btn-icon icon-right">Filter
                            <i class="fa fa-filter"></i>
                        </button>
                    </div>
            </form>
            <script type="text/javascript">
                $(function() {
                    moment.locale('id');
                    var start = moment($('#mulai').val());
                    var end = moment($('#akhir').val());

                    function cb(start, end) {
                        $('#reportrange span').html(start.format('D M Y') + ' - ' + end.format('DD MMMM YYYY'));
                        $('#mulai').val(start);
                        $('#akhir').val(end);
                    }
                    $('#reportrange').daterangepicker({
                        // autoUpdateInput: false,
                        startDate: start,
                        endDate: end,
                        ranges: {
                            '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                            'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                            'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                                'month').endOf('month')]
                        }
                    }, cb);
                });
            </script>
        </div>
        {{-- end filter --}}

    </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Laporan Keuangan Bulan {{ \Carbon\carbon::parse($start)->firstOfMonth()->isoFormat('MMMM') }}</h4>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th scope="col" colspan="3" class="bg-primary text-white">Modal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-light">
                                <td></td>
                                <th>Modal Tahun Sebelumnya</th>
                                <th>Rp. {{ number_format($mts) }}</th>
                            </tr>
                            @php
                                $b = [];
                            @endphp
                            @forelse ($bulan as $single=>$a)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <th>Modal Bulan {{ Carbon\Carbon::parse($a->first()->tanggal)->isoFormat('MMMM') }}
                                    </th>
                                    <th>
                                        Rp. {{ number_format($a->sum('kredit')) }}
                                        @php
                                            $b[] = $a->sum('kredit');
                                        @endphp
                                    </th>
                                </tr>
                            @empty
                            @endforelse
                            {{-- </tbody>
          <tfoot> --}}
                            <tr class="bg-light">
                                <td></td>
                                <th>Total Modal Tahun {{ Carbon\Carbon::parse($tahuniniStart)->isoFormat('YYYY') }}</th>
                                <th>Rp. {{ number_format(array_sum($b)) }}</th>
                            </tr>
                            <tr class="bg-light">
                                <td></td>
                                <th>Total Modal</th>
                                <th>Rp. {{ number_format(array_sum($b) + $mts) }}</th>
                            </tr>
                            {{-- </tfoot> --}}
                            {{-- </table>
        <table class="table table-sm table-hover"> --}}
                            <thead>
                                <tr>
                                    <th scope="col" colspan="3" class="bg-primary text-white">Aset</th>
                                </tr>
                            </thead>
                        <tbody>
                            <tr class="bg-light">
                                <td></td>
                                <th>Aset Tahun Sebelumnya</th>
                                <th>Rp. {{ number_format($ats) }}</th>
                            </tr>
                            @php
                                $c = [];
                            @endphp
                            @forelse ($transaksiAset as $single=>$b)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <th>Aset Bulan {{ Carbon\Carbon::parse($b->first()->tanggal)->isoFormat('MMMM') }}
                                    </th>
                                    <th>
                                        Rp. {{ number_format($b->sum('debet')) }}
                                        @php
                                            $c[] = $b->sum('debet');
                                        @endphp
                                    </th>
                                </tr>
                            @empty
                            @endforelse
                            {{-- </tbody>
          <tfoot> --}}
                            <tr class="bg-light">
                                <td></td>
                                <th>Total Aset Tahun {{ Carbon\Carbon::parse($tahuniniStart)->isoFormat('YYYY') }}</th>
                                <th>Rp. {{ number_format(array_sum($c)) }}</th>
                            </tr>
                            <tr class="bg-light">
                                <td></td>
                                <th>Total Aset</th>
                                <th>Rp. {{ number_format(array_sum($c) + $ats) }}</th>
                            </tr>
                            {{-- </tfoot> --}}
                            {{-- </table>
        <table class="table table-sm table-hover table-striped"> --}}
                            <thead>
                                <tr>
                                    <th scope="col" colspan="3" class="bg-primary text-white">Penerimaan</th>
                                </tr>
                            </thead>
                        <tbody>
                            @foreach ($pendapatan->sortBy('tanggal', SORT_NATURAL) as $pd)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    {{-- <td>{{$pd->tanggal}}</td> --}}
                                    <td>{{ $pd->uraian }}</td>
                                    <td>Rp.{{ number_format($pd->kredit) }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                        <tr class="border-top border-success">
                            <th colspan="2" class="text-right ">Penerimaan Bulan
                                {{ \Carbon\carbon::parse($start)->isoFormat('MMMM') }}</th>
                            @if ($pendapatan != null)
                                <th class="">Rp.{{ number_format($pendapatan->sum('kredit')) }}</th>
                            @else
                                <th class="">Rp.0</th>
                            @endif
                        </tr>
                        <tr>
                            <th colspan="2" class="text-right ">Sisa Saldo Bulan
                                {{ \Carbon\carbon::parse($start)->firstOfMonth()->subMonths(1)->isoFormat('MMMM') }}</th>
                            <th class="">Rp.{{ number_format(saldoBulanSebelumnya($start)) }}</th>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-right bg-secondary">Total Penerimaan</th>
                            @if ($pendapatan != null)
                                <th class="bg-secondary">
                                    Rp.{{ number_format(saldoBulanSebelumnya($start) + $pendapatan->sum('kredit')) }}
                                </th>
                            @else
                                <th class="bg-secondary">Rp.0</th>
                            @endif
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Pengeluaran</h4>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-hover table-responsive-sm">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Biaya</th>
                                <th scope="col">Pengeluaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $a = [];
                                $bRAB = [];
                                $perHeader = $semuaRAB;
                                $perJudul = $semuaRAB;
                                $perHeaderUnit = $semuaUnit;
                                $perJudulUnit = $semuaUnit;
                            @endphp
                            @foreach ($perHeader as $header => $semuaRAB)
                                <tr>
                                    <th colspan="3" class="bg-primary text-white">{{ $header }}</th>
                                </tr>
                                @php
                                    $y = 1;
                                @endphp
                                @foreach ($perJudul[$header] as $judul => $semuaRAB)
                                    {{-- {{dd($judul)}} --}}
                                    @if (hitungJudulRAB($judul, $start, $end) > 0)
                                        @php
                                            $a[$judul] = 0;
                                            $c[$judul] = 0;
                                            $totalIsi[$judul] = 0;
                                        @endphp

                                        <tr>
                                            <th colspan="3" class="">{{ $y, $y++ }}.
                                                {{ $judul }}</th>
                                        </tr>
                                        @php
                                            $n = 1;
                                        @endphp
                                        @foreach ($semuaRAB as $rab)
                                            @if (hitungTransaksiRABRange($rab->id, $start, $end) > 0)
                                                <tr>
                                                    <td>{{ $n, $n++ }}</td>
                                                    <td>{{ $rab->isi }}</td>
                                                    <th> <a class="text-warning font-weight-bold"
                                                            href="{{ route('transaksiRAB', ['id' => $rab->id]) }}"> Rp.
                                                            {{ number_Format(hitungTransaksiRABRange($rab->id, $start, $end)) }}</a>
                                                    </th>
                                                    @php
                                                        $totalIsi[$judul] += hitungTransaksiRABRange($rab->id, $start, $end);
                                                    @endphp
                                                </tr>
                                            @endif
                                        @endforeach
                                        @php
                                            $a[$judul] = $totalIsi[$judul];
                                        @endphp
                                        @php
                                            $c[$judul] = $a[$judul] - $c[$judul];
                                        @endphp
                                        <tr class="border-top border-success">
                                            <th colspan="2" class="text-right">Sub Total {{ $judul }}</th>
                                            <th class="">Rp. {{ number_format($c[$judul]) }}</th>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr>
                                    <th colspan="2" class=" bg-secondary text-right">TOTAL {{ $header }}</th>
                                    @php
                                        $bRAB[$header] = array_sum($a) - array_sum($bRAB); /* menghitung total header */
                                    @endphp
                                    <th class="bg-secondary">Rp. {{ number_format($bRAB[$header]) }}</th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <table class="table table-sm table-hover table-responsive-sm">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Biaya</th>
                                <th scope="col">Pengeluaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $a = [];
                                $b = [];
                                $c = [];
                                $totalIsi = [];
                            @endphp
                            @foreach ($perHeaderUnit as $header => $semuaUnit)
                                <tr>
                                    <th colspan="3" class="bg-primary text-white"> {{ $header }}</th>
                                </tr>
                                @foreach ($perJudulUnit[$header] as $judul => $semuaUnit)
                                    @php
                                        $a[$judul] = 0;
                                        $c[$judul] = 0;
                                        $totalIsi[$judul] = 0;
                                    @endphp
                                    <tr>
                                        <th colspan="3" class="">{{ $loop->iteration }}.
                                            {{ $judul }}
                                        </th>
                                    </tr>
                                    @php
                                        $n = 1;
                                    @endphp
                                    @foreach ($semuaUnit->sortBy('isi', SORT_NATURAL) as $rab)
                                        @if (hitungTransaksiRABUnitRange($rab->id, $start, $end) > 0)
                                            <tr>
                                                <td>{{ $n, $n++ }}</td>
                                                <td>{{ $rab->isi }}</td>
                                                <th> <a class="text-warning font-weight-bold"
                                                        href="{{ route('transaksiRABUnit', ['id' => $rab->id]) }}">
                                                        Rp.{{ number_format(hitungTransaksiRABUnitRange($rab->id, $start, $end)) }}</a>
                                                </th>
                                                @php
                                                    $totalIsi[$judul] += hitungTransaksiRABUnitRange($rab->id, $start, $end);
                                                @endphp
                                            </tr>
                                        @endif
                                    @endforeach
                                    @php
                                        $a[$judul] = $totalIsi[$judul];
                                    @endphp
                                    @php
                                        $c[$judul] = $a[$judul] - $c[$judul];
                                    @endphp
                                    <tr class="border-top border-success">
                                        <th colspan="2" class="text-right ">Sub Total {{ $judul }}</th>
                                        <th class="">Rp. {{ number_format($c[$judul]) }}</th>
                                    </tr>
                                @endforeach
                                @php
                                    $b[$header] = array_sum($c) - array_sum($b); /* menghitung total header */
                                @endphp
                                <tr>
                                    <th colspan="2" class=" bg-secondary text-right">TOTAL {{ $header }}</th>
                                    <th class="bg-secondary ">Rp. {{ number_format($b[$header]) }}</th>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" class="text-white bg-warning text-right">TOTAL PENGELUARAN</th>
                                <th class="bg-warning text-white">Rp.
                                    {{ number_format(array_sum($b) + array_sum($bRAB)) }}
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2" class="text-white bg-info text-right">LABA/RUGI Berjalan</th>
                                <th class="bg-info text-white">Rp.
                                    {{ number_format(saldoBulanSebelumnya($start) + $pendapatan->sum('kredit') - (array_sum($b) + array_sum($bRAB))) }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
