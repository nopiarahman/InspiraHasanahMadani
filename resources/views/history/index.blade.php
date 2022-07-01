@extends('layouts.tema')
@section('head')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section('menuHistory', 'active')

@if (request()->route()->getName() == 'history')
    @section('menuHistoryReguler', 'active')
@endif
@if (request()->route()->getName() == 'historyTambahan')
    @section('menuHistoryTambahan', 'active')
@endif

@section('content')
    <div class="section-header sticky-top">
        <div class="container">
            <div class="row">
                <div class="col-3">
                    @if (request()->route()->getName() == 'history')
                        <h1>History</h1>
                    @endif
                    @if (request()->route()->getName() == 'historyTambahan')
                        <h1>History Tambahan</h1>
                    @endif
                </div>

                <div class="col-9">
                    {{-- filter --}}
                    @if (request()->route()->getName() == 'history')
                        <form action="{{ route('history') }}" method="get" enctype="multipart/form-data">
                    @endif
                    @if (request()->route()->getName() == 'historyTambahan')
                        <form action="{{ route('historyTambahan') }}" method="get" enctype="multipart/form-data">
                    @endif

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-6 col-lg-6 mt-1 mr-n3"> <span
                                style="font-size:small">Pilih Tanggal: </span> </label>
                        <div class="input-group col-sm-12 col-md-6">
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
                                startDate: start,
                                endDate: end,
                                ranges: {
                                    'Hari Ini': [moment(), moment()],
                                    'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                    '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
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

    <div class="card">
        <div class="card-header">
            <h4>Daftar History Transaksi</h4>
        </div>
        <div class="card-body">
            <table class="table table-sm table-hover table-striped mt-3" id="table">
                <thead>
                    <tr>
                        <th scope="col">Jenis</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Uraian</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">User</th>
                        <th scope="col">Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($history as $h)
                        <tr>
                            <td>
                                @if ($h->jenis == 'penambahan')
                                    <span class="text-primary">{{ Str::ucfirst($h->jenis) }}</span>
                                @elseif($h->jenis == 'hapus' || $h->jenis == 'pengeluaran')
                                    <span class="text-danger">{{ Str::ucfirst($h->jenis) }}</span>
                                @elseif($h->jenis == 'update' || $h->jenis == 'Update kas' || $h->jenis == 'Alokasi Gudang')
                                    <span class="text-warning">{{ Str::ucfirst($h->jenis) }}</span>
                                @endif
                            </td>
                            <td data-order="{{ $h->created_at }}">{{ formatWaktuTanggal($h->created_at) }}</td>
                            <td>{{ $h->uraian }}</td>
                            <td data-order="{{ $h->jumlah }}">Rp.{{ number_format($h->jumlah) }}</td>
                            <td>{{ $h->user->name }}</td>
                            <td>{{ $h->user->role }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script type="text/javascript">
        $('#table').DataTable({
            "pageLength": 25,
            "order": [],
            "language": {
                "decimal": "",
                "emptyTable": "Tidak ada data tersedia",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Menampilkan _MENU_ data",
                "loadingRecords": "Loading...",
                "processing": "Processing...",
                "search": "Cari:",
                "zeroRecords": "Tidak ada data ditemukan",
                "paginate": {
                    "first": "Awal",
                    "last": "Akhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                },
            }
        });
    </script>
@endsection
