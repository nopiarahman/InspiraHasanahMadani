@extends('layouts.tema')
@section('head')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section('menuPengadaan', 'active')
@section('menuDaftarPengadaan', 'active')
@section('content')
    <div class="section-header sticky-top">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1>{{ $id->deskripsi }}</h1>
                </div>
                <div class="kanan">
                    <a href="{{ route('exportIsiPengadaan', ['id' => $id->id]) }}" class="btn btn-primary"> <i
                            class="fas fa-file-excel"></i>
                        Export Excel</a>
                </div>
            </div>
            <div class="row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb  bg-white mb-n2">
                        <li class="breadcrumb-item"> <a href="{{ route('pengadaan') }}"> Daftar Pengadaan </a></li>
                        <li class="breadcrumb-item" aria-current="page"> isi </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Alert --}}
    <div class="row">
        <div class="col-12">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible show fade">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('status') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-warning alert-dismissible show fade">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>
    @if (auth()->user()->role == 'admin' ||
        auth()->user()->role == 'adminGudang' ||
        auth()->user()->role == 'marketing' ||
        auth()->user()->role == 'gudang')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Barang </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('isiPengadaanSimpan', ['id' => $id->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Barang</label>
                                <div class="col-sm-12 col-md-7">
                                    <select class="cari form-control" style="width:300px;height:calc(1.5em + .75rem + 2px);"
                                        name="barang_id"></select>
                                    {{-- <input type="text" class="form-control @error('objek') is-invalid @enderror" name="objek" value="{{old('objek')}}"> --}}
                                    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
                                    <script type="text/javascript">
                                        $('.cari').select2({
                                            placeholder: 'Pilih Barang...',
                                            ajax: {
                                                url: '/cariBarang',
                                                dataType: 'json',
                                                delay: 250,
                                                processResults: function(data) {
                                                    return {
                                                        results: $.map(data, function(item) {
                                                            return {
                                                                text: item.namaBarang + " " + item.merek + " Rp." + item.harga + "/" +
                                                                    item.satuan,
                                                                /* memasukkan text di option => <option>namaSurah</option> */
                                                                id: item.id /* memasukkan value di option => <option value=id> */
                                                            }
                                                        })
                                                    };
                                                },
                                                cache: true
                                            }
                                        });
                                    </script>
                                    @error('barang_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jumlah</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('jumlahBarang') is-invalid @enderror"
                                        name="jumlahBarang" value="{{ old('jumlahBarang') }}">
                                    @error('jumlahBarang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Keterangan</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                        name="keterangan" value="{{ old('keterangan') }}">
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                <div class="col-sm-12 col-md-7">
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h4>Daftar Barang</h4>
        </div>
        <div class="card-body">
            <table class="table table-responsive-sm table-hover" id="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Merek</th>
                        <th scope="col">Jumlah Barang</th>
                        <th scope="col">Estimasi Harga</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($semuaIsi as $isi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $isi->namaBarang }}</td>
                            <td>{{ $isi->merek }}</td>
                            <td>{{ $isi->jumlahBarang }} {{ $isi->satuan }}</td>
                            <td>Rp. {{ number_format($isi->totalHarga) }}</td>
                            <td>{{ $isi->keterangan }}</td>
                            <td>
                                @if ($isi->status == 0)
                                    <span class="badge badge-primary">Baru</span>
                                @elseif($isi->status == 1)
                                    <span class="badge badge-info text-white">Diterima</span>
                                @elseif($isi->status == 2)
                                    <span class="badge badge-warning text-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                @if (auth()->user()->role == 'admin' || auth()->user()->role == 'gudang')
                                    <button type="button" class="btn btn-sm btn-white text-danger border-danger"
                                        data-toggle="modal" data-target="#exampleModalCenter" data-id="{{ $isi->id }}"
                                        data-nama="{{ $isi->namaBarang }}">
                                        <i class="fa fa-trash" aria-hidden="true"></i> Hapus</button>
                                @endif
                                @if (auth()->user()->role == 'projectmanager' || auth()->user()->role == 'admin')
                                    <a href="{{ route('terimaPengadaan', ['id' => $isi->id]) }}"
                                        class="btn btn-sm text-primary border-success"> <i class="fa fa-check"
                                            aria-hidden="true"></i> Terima</a>
                                    <a href="{{ route('tolakPengadaan', ['id' => $isi->id]) }}"
                                        class="btn btn-sm text-danger border-danger"> <i class="fas fa-times    "></i>
                                        Tolak</a>
                                @endif
                                @if (auth()->user()->role == 'admin' ||
                                    auth()->user()->role == 'adminGudang' ||
                                    auth()->user()->role == 'marketing' ||
                                    auth()->user()->role == 'gudang')
                                    @if ($isi->status == 1 && $isi->statusTransfer == 0)
                                        <a href="{{ route('buatTransaksi', ['id' => $isi->id]) }}"
                                            class="btn btn-sm text-primary border-success"> <i
                                                class="fas fa-handshake    "></i> Buat Transaksi</a>
                                    @elseif($isi->statusTransfer == 1)
                                        <a href="#" class="btn btn-sm text-info border-info"> <i
                                                class="fas fa-check" aria-hidden="true"></i> Transaksi dibuat</a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="bg-secondary text-right text-primary">Total Estimasi Harga</th>
                        <th colspan="4" class="bg-secondary  text-primary">Rp.
                            {{ number_format($semuaIsi->sum('totalHarga')) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Modal Hapus-->
    <div class="modal fade exampleModalCenter" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Hapus Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="formHapus">
                        @method('delete')
                        @csrf
                        <p class="modal-text"></p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Hapus</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ mix('js/cleave.min.js') }}"></script>
    <script src="{{ mix('js/addons/cleave-phone.id.js') }}"></script>

    <script>
        var cleave = new Cleave('.hargaEdit', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#exampleModalCenter').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var id = button.data('id') // Extract info from data-* attributes
                var nama = button.data('nama')
                var modal = $(this)
                modal.find('.modal-text').text('Hapus Barang ' + nama + ' ?')
                document.getElementById('formHapus').action = '/hapusIsiPengadaan/' + id;
            })
        });
    </script>
@endsection
@section('script')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script type="text/javascript">
        $('#table').DataTable({
            "pageLength": 25,
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
