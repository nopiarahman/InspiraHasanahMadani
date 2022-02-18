@extends('layouts.tema')
@if (request()->route()->getName() == 'RAB')
    @section('menuRAB', 'active')
@endif
@if (request()->route()->getName() == 'RABGudang')
    @section('menuRABGudang', 'active')
@endif
@section('menuDataProyek', 'active')
@section('content')
    <div class="section-header">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1>RAB</h1>
                </div>
                <div class="kanan">
                    @if (request()->route()->getName() == 'RAB')
                        <a href="{{ route('cetakRAB') }}" class="btn btn-primary"> <i class="fas fa-file-excel"></i> Export
                            Excel</a>
                    @endif
                    @if (request()->route()->getName() == 'RABGudang')
                        <a href="{{ route('cetakRABGudang') }}" class="btn btn-primary"> <i class="fas fa-file-excel"></i>
                            Export Excel</a>
                    @endif
                </div>
            </div>
            <div class="row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb  bg-white mb-n2">
                        <li class="breadcrumb-item" aria-current="page"> RAB </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    @if (auth()->user()->role == 'admin' || auth()->user()->role == 'projectmanager')
        <div class="section-header">
            {{-- <a href="{{route('RAB')}}"  class="btn btn-primary disabled ">RAB</a>
    <a href="{{route('biayaUnit')}}" class="btn btn-primary ml-2">Biaya Unit</a> --}}
            <button class="btn btn-primary" onclick="tampilFormRAB()">RAB</button>
            <button class="btn btn-primary ml-2" onclick="tampilFormUnit()">Biaya Unit</button>
            <script>
                function tampilFormRAB() {
                    var formRAB = document.querySelector('.formRAB');
                    formRAB.className = 'row formRAB';

                    var formBiayaUnit = document.querySelector('.formBiayaUnit');
                    formBiayaUnit.className = 'row formBiayaUnit d-none';

                }

                function tampilFormUnit() {
                    var formRAB = document.querySelector('.formRAB');
                    formRAB.className = 'row formRAB d-none';

                    var formBiayaUnit = document.querySelector('.formBiayaUnit');
                    formBiayaUnit.className = 'row formBiayaUnit';

                }
            </script>
        </div>
    @endif
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
    @if (auth()->user()->role == 'admin' || auth()->user()->role == 'projectmanager')
        <div class="row formRAB">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Jenis Biaya Baru</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('biayaRABSimpan') }}" method="POST" enctype="multipart/form-data"
                            onchange="hitung()">
                            @csrf
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Header</label>
                                <div class="input-group col-sm-12 col-md-7">
                                    <div class="input-group-prepend">
                                        <select name="headerLama" id="header" class="form-control headerAkun">
                                        </select>
                                    </div>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text " style="border: none">
                                            atau
                                            <a class="btn btn-primary ml-3" onclick="inputBaru()">Header Baru</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-4 headerBaru d-none">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Input Header
                                    Baru</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('headerBaru') is-invalid @enderror"
                                        name="header" value="{{ old('headerBaru') }} " onchange="removeHeader()">
                                    @error('headerBaru')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
                            <script type="text/javascript">
                                $('.headerAkun').select2({
                                    placeholder: 'Pilih Header...',
                                    ajax: {
                                        url: '/cariHeader',
                                        dataType: 'json',
                                        delay: 250,
                                        processResults: function(data) {
                                            return {
                                                results: $.map(data, function(item) {
                                                    return {
                                                        text: item.header,
                                                        /* memasukkan text di option => <option>namaSurah</option> */
                                                        id: item.header /* memasukkan value di option => <option value=id> */
                                                    }
                                                })
                                            };
                                        },
                                        cache: true
                                    }
                                });
                            </script>
                            <script>
                                function inputBaru() {
                                    var inputBaru = document.querySelector('.headerBaru');
                                    inputBaru.className = 'form-group row mb-4 headerBaru';
                                }
                                document.getElementById("header").onchange = changeListener;

                                function changeListener() {
                                    var value = this.value
                                    var inputBaru = document.querySelector('.headerBaru');
                                    console.log(value);
                                    if (value == "input") {
                                        inputBaru.className = 'form-group row mb-4 headerBaru';
                                    } else {
                                        inputBaru.className = 'form-group row mb-4 headerBaru d-none';
                                    }
                                }
                            </script>

                            <script>
                                function removeHeader() {
                                    var select = document.getElementById("header");
                                    var length = select.options.length;
                                    for (i = length - 1; i >= 0; i--) {
                                        select.options[i] = null;
                                    }
                                }
                            </script>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Judul</label>
                                <div class="input-group col-sm-12 col-md-7">
                                    <div class="input-group-prepend">
                                        <select name="judulLama" id="judul" class="form-control judulRab">
                                        </select>
                                    </div>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text " style="border: none">
                                            atau
                                            <a class="btn btn-primary ml-3" onclick="inputJudulBaru()">Judul Baru</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-4 judulBaru d-none">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Input Judul
                                    Baru</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('judulBaru') is-invalid @enderror"
                                        name="judul" value="{{ old('judulBaru') }} " onchange="removeJudul()">
                                    @error('judulBaru')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
                            <script type="text/javascript">
                                $('.judulRab').select2({
                                    placeholder: 'Pilih Judul...',
                                    ajax: {
                                        url: '/cariJudul',
                                        dataType: 'json',
                                        delay: 250,
                                        processResults: function(data) {
                                            return {
                                                results: $.map(data, function(item) {
                                                    return {
                                                        text: item.judul,
                                                        /* memasukkan text di option => <option>namaSurah</option> */
                                                        id: item.judul /* memasukkan value di option => <option value=id> */
                                                    }
                                                })
                                            };
                                        },
                                        cache: true
                                    }
                                });
                            </script>
                            <script>
                                function inputJudulBaru() {
                                    var inputJudulBaru = document.querySelector('.judulBaru');
                                    inputJudulBaru.className = 'form-group row mb-4 judulBaru';
                                }
                                document.getElementById("judul").onchange = changeListener;

                                function changeListener() {
                                    var value = this.value
                                    var inputJudulBaru = document.querySelector('.judulBaru');
                                    console.log(value);
                                    if (value == "input") {
                                        inputJudulBaru.className = 'form-group row mb-4 judulBaru';
                                    } else {
                                        inputJudulBaru.className = 'form-group row mb-4 judulBaru d-none';
                                    }
                                }
                            </script>

                            <script>
                                function removeJudul() {
                                    var select = document.getElementById("judul");
                                    var length = select.options.length;
                                    for (i = length - 1; i >= 0; i--) {
                                        select.options[i] = null;
                                    }
                                }
                            </script>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kode RAB</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('isi') is-invalid @enderror"
                                        name="kodeRAB" value="{{ old('kodeRAB') }}">
                                    @error('kodeRAB')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Isi Biaya</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('isi') is-invalid @enderror" name="isi"
                                        value="{{ old('isi') }}">
                                    @error('isi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Volume</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('volume') is-invalid @enderror"
                                        name="volume" value="{{ old('volume') }}" id="volume"
                                        placeholder="diisi dengan angka atau persen">
                                    @error('volume')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Satuan</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('satuan') is-invalid @enderror"
                                        name="satuan" value="{{ old('satuan') }}">
                                    @error('satuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga Satuan</label>
                                <div class="input-group col-sm-12 col-md-7">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp
                                        </div>
                                    </div>
                                    <input type="text" class="form-control @error('hargaSatuan') is-invalid @enderror"
                                        name="hargaSatuan" value="{{ old('hargaSatuan') }}" id="hargaSatuan">
                                    @error('hargaSatuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Total</label>
                                <div class=" input-group col-sm-12 col-md-7">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp
                                        </div>
                                    </div>
                                    <input readonly type="text"
                                        class="total form-control @error('total') is-invalid @enderror" name="total"
                                        value="{{ old('total') }}" id="total">
                                    @error('total')
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
        <div class="row formBiayaUnit d-none">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Jenis Biaya Unit</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('rabUnitSimpan') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-4 col-lg-3">Header</label>
                                <div class="input-group col-sm-12 col-md-7">
                                    <div class="input-group-prepend">
                                        <select name="headerLama" id="headerUnit" class="form-control headerAkunUnit">
                                        </select>
                                    </div>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text " style="border: none">
                                            atau
                                            <a class="btn btn-primary ml-3" onclick="inputBaruUnit()">Header Baru</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-4 headerBaruUnit d-none">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Input Header
                                    Baru</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('headerBaru') is-invalid @enderror"
                                        name="header" value="{{ old('headerBaru') }} " onchange="removeHeaderUnit()">
                                    @error('headerBaru')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
                            <script type="text/javascript">
                                $('.headerAkunUnit').select2({
                                    placeholder: 'Pilih Header...',
                                    ajax: {
                                        url: '/cariHeaderUnit',
                                        dataType: 'json',
                                        delay: 250,
                                        processResults: function(data) {
                                            return {
                                                results: $.map(data, function(item) {
                                                    return {
                                                        text: item.header,
                                                        /* memasukkan text di option => <option>namaSurah</option> */
                                                        id: item.header /* memasukkan value di option => <option value=id> */
                                                    }
                                                })
                                            };
                                        },
                                        cache: true
                                    }
                                });
                            </script>
                            <script>
                                function inputBaruUnit() {
                                    var inputBaru = document.querySelector('.headerBaruUnit');
                                    inputBaru.className = 'form-group row mb-4 headerBaruUnit';
                                }
                                document.getElementById("headerUnit").onchange = changeListener;

                                function changeListener() {
                                    var value = this.value
                                    var inputBaru = document.querySelector('.headerBaruUnit');
                                    console.log(value);
                                    if (value == "input") {
                                        inputBaru.className = 'form-group row mb-4 headerBaruUnit';
                                    } else {
                                        inputBaru.className = 'form-group row mb-4 headerBaruUnit d-none';
                                    }
                                }
                            </script>

                            <script>
                                function removeHeaderUnit() {
                                    var select = document.getElementById("headerUnit");
                                    var length = select.options.length;
                                    for (i = length - 1; i >= 0; i--) {
                                        select.options[i] = null;
                                    }
                                }
                            </script>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Judul</label>
                                <div class="input-group col-sm-12 col-md-7">
                                    <div class="input-group-prepend">
                                        <select name="judulLama" id="judulUnit" class="form-control judulRabUnit">
                                        </select>
                                    </div>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text " style="border: none">
                                            atau
                                            <a class="btn btn-primary ml-3" onclick="inputJudulBaruUnit()">Judul Baru</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-4 judulBaruUnit d-none">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Input Judul
                                    Baru</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('judulBaru') is-invalid @enderror"
                                        name="judul" value="{{ old('judulBaru') }} " onchange="removeJudulUnit()">
                                    @error('judulBaru')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
                            <script type="text/javascript">
                                $('.judulRabUnit').select2({
                                    placeholder: 'Pilih Judul...',
                                    ajax: {
                                        url: '/cariJudulUnit',
                                        dataType: 'json',
                                        delay: 250,
                                        processResults: function(data) {
                                            return {
                                                results: $.map(data, function(item) {
                                                    return {
                                                        text: item.judul,
                                                        /* memasukkan text di option => <option>namaSurah</option> */
                                                        id: item.judul /* memasukkan value di option => <option value=id> */
                                                    }
                                                })
                                            };
                                        },
                                        cache: true
                                    }
                                });
                            </script>
                            <script>
                                function inputJudulBaruUnit() {
                                    var inputJudulBaru = document.querySelector('.judulBaruUnit');
                                    inputJudulBaru.className = 'form-group row mb-4 judulBaruUnit';
                                }
                                document.getElementById("judulUnit").onchange = changeListener;

                                function changeListener() {
                                    var value = this.value
                                    var inputJudulBaru = document.querySelector('.judulBaruUnit');
                                    console.log(value);
                                    if (value == "input") {
                                        inputJudulBaru.className = 'form-group row mb-4 judulBaruUnit';
                                    } else {
                                        inputJudulBaru.className = 'form-group row mb-4 judulBaruUnit d-none';
                                    }
                                }
                            </script>

                            <script>
                                function removeJudulUnit() {
                                    var select = document.getElementById("judulUnit");
                                    var length = select.options.length;
                                    for (i = length - 1; i >= 0; i--) {
                                        select.options[i] = null;
                                    }
                                }
                            </script>


                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Isi Biaya</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('isi') is-invalid @enderror" name="isi"
                                        value="{{ old('isi') }}">
                                    @error('isi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kode RAB</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('isi') is-invalid @enderror"
                                        name="kodeRAB" value="{{ old('kodeRAB') }}">
                                    @error('kodeRAB')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis</label>
                                <div class="col-sm-12 col-md-7">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="jenisUnit" value="kavling" class="selectgroup-input"
                                            checked="">
                                        <span class="selectgroup-button">Kavling</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="jenisUnit" value="rumah" class="selectgroup-input">
                                        <span class="selectgroup-button">Rumah</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="jenisUnit" value="kios" class="selectgroup-input">
                                        <span class="selectgroup-button">Kios</span>
                                    </label>
                                    @error('jenisUnit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Volume</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('volume') is-invalid @enderror"
                                        name="volume" value="{{ old('volume') }}" id="volume"
                                        placeholder="diisi dengan angka atau persen">
                                    @error('volume')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga Satuan</label>
                                <div class="input-group col-sm-12 col-md-7">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp
                                        </div>
                                    </div>
                                    <input type="text"
                                        class="hargaSatuanUnit form-control @error('hargaSatuan') is-invalid @enderror"
                                        name="hargaSatuan" value="{{ old('hargaSatuan') }}" id="hargaSatuanUnit">
                                    @error('hargaSatuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <script src="{{ mix('js/cleave.min.js') }}"></script>
                            <script>
                                var cleave = new Cleave('.hargaSatuanUnit', {
                                    numeral: true,
                                    numeralThousandsGroupStyle: 'thousand'
                                });
                            </script>
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
            <h4>RAB</h4>
        </div>
        <div class="card-body">
            <table class="table table-sm table-hover table-responsive-sm">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col"></th>
                        <th scope="col">Biaya</th>
                        <th scope="col">Volume</th>
                        <th scope="col">Satuan</th>
                        <th scope="col">Harga Satuan</th>
                        <th scope="col">Total</th>
                        <th scope="col">Pengeluaran</th>
                        <th scope="col">Persentase</th>
                        @if (auth()->user()->role == 'admin')
                            <th scope="col">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php
                        $a = [];
                        $bRAB = [];
                        $perHeader = $semuaRAB;
                        $perJudul = $semuaRAB;
                    @endphp
                    @foreach ($perHeader as $header => $semuaRAB)
                        <tr>
                            <th colspan="10" class="bg-primary text-white">{{ $header }}</th>
                        </tr>
                        @foreach ($perJudul[$header] as $judul => $semuaRAB)
                            <tr>
                                <th colspan="10" class="">{{ $loop->iteration }}. {{ $judul }}
                                </th>
                            </tr>
                            @foreach ($semuaRAB as $rab)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $rab->kodeRAB }}</td>
                                    <td>{{ $rab->isi }}</td>
                                    <td>{{ $rab->volume }}</td>
                                    <td>{{ $rab->satuan }}</td>
                                    <td>Rp.{{ number_format((int) $rab->hargaSatuan) }}</td>
                                    <th>Rp.{{ number_format($rab->total) }}</th>
                                    <th> <a class="text-warning font-weight-bold"
                                            href="{{ route('transaksiRAB', ['id' => $rab->id]) }}"> Rp.
                                            {{ number_Format(hitungTransaksiRAB($rab->id)) }}</a></th>

                                    <th>
                                        @if ($rab->total != 0)
                                            {{ number_format((float) ((hitungTransaksiRAB($rab->id) / $rab->total) * 100), 2) }}%
                                        @else
                                            -
                                        @endif
                                    </th>
                                    @if (auth()->user()->role == 'admin')
                                        <th>
                                            <button type="button" class="btn btn-sm btn-white text-primary border-success"
                                                data-toggle="modal" data-target="#modalEdit" data-id="{{ $rab->id }}"
                                                data-header="{{ $rab->header }}" data-judul="{{ $rab->judul }}"
                                                data-isi="{{ $rab->isi }}" data-volume="{{ $rab->volume }}"
                                                data-satuan="{{ $rab->satuan }}" data-harga="{{ $rab->hargaSatuan }}"
                                                data-kode="{{ $rab->kodeRAB }}" data-total="{{ $rab->total }}">
                                                <i class="fa fa-pen" aria-hidden="true"></i> Edit</button>

                                            <button type="button" class="btn btn-sm btn-white text-danger border-danger"
                                                data-toggle="modal" data-target="#exampleModalCenter"
                                                data-id="{{ $rab->id }}" data-isi="{{ $rab->isi }}">
                                                <i class="fa fa-trash" aria-hidden="true"></i> Hapus</button>
                                        </th>
                                    @endif
                                </tr>
                            @endforeach
                            <tr class="border-top border-success">
                                <th colspan="6" class="text-right">Sub Total {{ $judul }}</th>
                                <th colspan="" class="">Rp. {{ number_format($semuaRAB->sum('total')) }}
                                </th>
                                <th>Rp. {{ number_format(transaksiRAB($judul)) }}</th>
                            </tr>
                            @php
                                $a[] = $semuaRAB->sum('total'); /* menghitung per total judul */
                            @endphp
                        @endforeach
                        <tr>
                            <th colspan="6" class=" bg-secondary text-right">TOTAL {{ $header }}</th>
                            @php
                                $bRAB[$header] = array_sum($a) - array_sum($bRAB); /* menghitung total header */
                            @endphp
                            <th colspan="6" class="bg-secondary">Rp. {{ number_format($bRAB[$header]) }}</th>
                        </tr>
                    @endforeach
                </tbody>
                {{-- <tfoot>
            <tr>
              <th colspan="5" class="text-white bg-warning text-right">TOTAL RAB</th>
              <th colspan="4" class="bg-warning text-white" >Rp. {{number_format(array_sum($bRAB))}}</th>
          </tr>
        </tfoot> --}}
            </table>
            {{-- </div> --}}
            {{-- <div class="card-body"> --}}
            <table class="table table-sm table-hover table-responsive-sm">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col"></th>
                        <th scope="col">Biaya</th>
                        <th scope="col">Jenis</th>
                        <th scope="col">Volume</th>
                        <th scope="col">Satuan</th>
                        <th scope="col">Harga Satuan</th>
                        <th scope="col">Total</th>
                        <th scope="col">Pengeluaran</th>
                        <th scope="col">Persentase</th>
                        @if (auth()->user()->role == 'admin')
                            <th scope="col">Aksi</th>
                        @endif
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
                            <th colspan="11" class="bg-primary text-white"> {{ $header }}</th>
                        </tr>
                        @foreach ($perJudulUnit[$header] as $judul => $semuaUnit)
                            @php
                                $a[$judul] = 0;
                                $c[$judul] = 0;
                                $totalIsi[$judul] = 0;
                                $totalJudul[$judul] = 0;
                                
                            @endphp
                            <tr>
                                <th colspan="11" class="">{{ $loop->iteration }}. {{ $judul }}
                                </th>
                            </tr>
                            @foreach ($semuaUnit->sortBy('isi', SORT_NATURAL) as $rab)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $rab->kodeRAB }}</td>
                                    <td>{{ $rab->isi }}</td>
                                    <td>{{ $rab->jenisUnit }}</td>
                                    @if ($rab->header == 'BIAYA PRODUKSI RUMAH')
                                        <td>{{ hitungUnit($rab->isi, $rab->judul, $rab->jenisUnit) }}</td>
                                    @else
                                        <td>{{ $rab->volume }}</td>
                                    @endif
                                    <td>{{ satuanUnit($rab->judul) }}</td>
                                    <td>Rp.{{ number_format((int) $rab->hargaSatuan) }}</td>
                                    @if ($rab->header == 'BIAYA PRODUKSI RUMAH')
                                        <td>Rp.
                                            {{ number_format(hitungUnit($rab->isi, $rab->judul, $rab->jenisUnit) * (int) $rab->hargaSatuan) }}
                                        </td>
                                    @else
                                        <th>Rp.{{ number_format($rab->volume * (int) $rab->hargaSatuan) }}
                                    @endif
                                    </th>
                                    @if ($rab->header == 'BIAYA PRODUKSI RUMAH')
                                        @php
                                            $totalIsi[$judul] = hitungUnit($rab->isi, $rab->judul, $rab->jenisUnit) * (int) $rab->hargaSatuan + $totalIsi[$judul];
                                        @endphp
                                    @else
                                        @php
                                            $totalIsi[$judul] = $rab->volume * (int) $rab->hargaSatuan + $totalIsi[$judul];
                                        @endphp
                                    @endif
                                    <th> <a class="text-warning font-weight-bold"
                                            href="{{ route('transaksiRABUnit', ['id' => $rab->id]) }}">
                                            Rp.{{ number_format(hitungTransaksiRABUnit($rab->id)) }}</a></th>
                                    <th>
                                        @if ((int) $rab->hargaSatuan != 0)
                                            {{-- pengeluaran/total*100 --}}
                                            {{-- {{number_format((float)(hitungTransaksiRABUnit($rab->id)/(hitungUnit($rab->isi,$rab->judul,$rab->jenisUnit)*(int)$rab->hargaSatuan)*100),2)}}% --}}

                                        @else
                                            -
                                        @endif
                                    </th>
                                    @if (auth()->user()->role == 'admin')
                                        <th>
                                            @if ($rab->header == 'BIAYA PRODUKSI RUMAH')
                                            @else
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-primary border-success"
                                                    data-toggle="modal" data-target="#modalEditUnit"
                                                    data-id="{{ $rab->id }}" data-header="{{ $rab->header }}"
                                                    data-judul="{{ $rab->judul }}" data-isi="{{ $rab->isi }}"
                                                    data-jenis="{{ $rab->jenisUnit }}"
                                                    data-volume="{{ $rab->volume }}" data-kode="{{ $rab->kodeRAB }}"
                                                    data-jenis="{{ $rab->jenisUnit }}"
                                                    data-harga="{{ $rab->hargaSatuan }}">
                                                    <i class="fa fa-pen" aria-hidden="true"></i> Edit</button>

                                                <button type="button"
                                                    class="btn btn-sm btn-white text-danger border-danger"
                                                    data-toggle="modal" data-target="#exampleModalCenterUnit"
                                                    data-id="{{ $rab->id }}" data-isi="{{ $rab->isi }}">
                                                    <i class="fa fa-trash" aria-hidden="true"></i> Hapus</button>
                                            @endif
                                        </th>
                                    @endif
                                </tr>
                            @endforeach
                            @php
                                $a[$judul] = $totalIsi[$judul];
                            @endphp
                            @php
                                $c[$judul] = $a[$judul] - $c[$judul];
                            @endphp
                            <tr class="border-top border-success">
                                <th colspan="7" class="text-right ">Sub Total {{ $judul }}</th>
                                <th colspan="" class="">Rp. {{ number_format($c[$judul]) }}</th>
                                <th>Rp. {{ number_format(transaksiRABUnit($judul)) }}</th>

                            </tr>
                        @endforeach
                        @php
                            $b[$header] = array_sum($c) - array_sum($b); /* menghitung total header */
                        @endphp
                        <tr>
                            <th colspan="7" class=" bg-secondary text-right">TOTAL {{ $header }}</th>
                            <th colspan="4" class="bg-secondary ">Rp. {{ number_format($b[$header]) }}</th>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="7" class="text-white bg-warning text-right">TOTAL RAB</th>
                        <th colspan="4" class="bg-warning text-white">Rp.
                            {{ number_format(array_sum($b) + array_sum($bRAB)) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    {{-- {{$semuaKavling->links()}} --}}
    <script src="{{ mix('js/cleave.min.js') }}"></script>
    <script>
        function hitung() {

            var volume = document.getElementById('volume').value;
            var hargaSatuan = document.getElementById('hargaSatuan').value;
            var check = volume.includes("%");
            if (check == true) {
                var regex = /\d+/;
                var trim = volume.match(regex);
                var total = (trim * hargaSatuan) / 100;

            } else {
                var total = volume * hargaSatuan;
            }
            document.getElementById('total').value = total;
            var cleave = new Cleave('.total', {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand'
            });
        }
    </script>
    {{-- modal Edit --}}
    <div class="modal fade modalEdit bd-example-modal-lg ml-5" id="modalEdit" tabindex="-1" role="dialog"
        aria-labelledby="modalEditTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit RAB</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data" id="formEdit" onchange="hitung2()">
                        @method('patch')
                        @csrf
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kode RAB</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control @error('isi') is-invalid @enderror" name="kodeRAB"
                                    value="{{ old('kodeRAB') }}" id="kodeRABEdit">
                                @error('kodeRAB')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Isi Biaya</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control @error('isi') is-invalid @enderror" name="isi"
                                    value="{{ old('isi') }}" id="isiEdit">
                                @error('isi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Volume</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control @error('volume') is-invalid @enderror"
                                    name="volume" value="{{ old('volume') }}" id="volumeEdit"
                                    placeholder="diisi dengan angka atau persen">
                                @error('volume')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Satuan</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control @error('satuan') is-invalid @enderror"
                                    name="satuan" value="{{ old('satuan') }}" id="satuanEdit">
                                @error('satuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga Satuan</label>
                            <div class="input-group col-sm-12 col-md-7">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        Rp
                                    </div>
                                </div>
                                <input type="text"
                                    class="hargaSatuanEdit form-control @error('hargaSatuan') is-invalid @enderror"
                                    name="hargaSatuan" value="{{ old('hargaSatuan') }}" id="hargaSatuanEdit">
                                @error('hargaSatuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Total</label>
                            <div class=" input-group col-sm-12 col-md-7">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        Rp
                                    </div>
                                </div>
                                <input readonly type="text"
                                    class="totalEdit form-control @error('total') is-invalid @enderror" name="total"
                                    value="{{ old('total') }}" id="totalEdit">
                                @error('total')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button class="btn btn-primary" type="submit">Edit</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Hapus-->
    <div class="modal fade exampleModalCenter" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Hapus RAB</h5>
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

    {{-- modal Edit --}}
    <div class="modal fade modalEditUnit bd-example-modal-lg ml-5" id="modalEditUnit" tabindex="-1" role="dialog"
        aria-labelledby="modalEditTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit RAB</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data" id="formEditUnit" onchange="hitung2()">
                        @method('patch')
                        @csrf
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kode RAB</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control @error('isi') is-invalid @enderror" name="kodeRAB"
                                    value="{{ old('kodeRAB') }}" id="kodeEditUnit">
                                @error('kodeRAB')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Isi Biaya</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control @error('isi') is-invalid @enderror" name="isi"
                                    value="{{ old('isi') }}" id="isiEditUnit">
                                @error('isi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis</label>
                            <div class="col-sm-12 col-md-7">
                                <label class="selectgroup-item">
                                    <input type="radio" name="jenisUnit" value="kavling" class="selectgroup-input"
                                        checked="" id="jenisKavling">
                                    <span class="selectgroup-button">Kavling</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="jenisUnit" value="rumah" class="selectgroup-input"
                                        id="jenisRumah">
                                    <span class="selectgroup-button">Rumah</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="jenisUnit" value="kios" class="selectgroup-input"
                                        id="jenisKios">
                                    <span class="selectgroup-button">Kios</span>
                                </label>
                                @error('jenisUnit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Volume</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control @error('volume') is-invalid @enderror"
                                    name="volume" value="{{ old('volume') }}" id="volumeEditUnit"
                                    placeholder="diisi dengan angka atau persen">
                                @error('volume')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga Satuan</label>
                            <div class="input-group col-sm-12 col-md-7">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        Rp
                                    </div>
                                </div>
                                <input type="text"
                                    class="hargaSatuanEditUnit form-control @error('hargaSatuan') is-invalid @enderror"
                                    name="hargaSatuan" value="{{ old('hargaSatuan') }}" id="hargaSatuanEditUnit">
                                @error('hargaSatuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <script src="{{ mix('js/cleave.min.js') }}"></script>
                        <script>
                            var cleave = new Cleave('.hargaSatuanEditUnit', {
                                numeral: true,
                                numeralThousandsGroupStyle: 'thousand'
                            });
                        </script>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button class="btn btn-primary" type="submit">Edit</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Hapus-->
    <div class="modal fade exampleModalCenterUnit" id="exampleModalCenterUnit" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Hapus RAB</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="formHapusUnit">
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#exampleModalCenterUnit').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var id = button.data('id') // Extract info from data-* attributes
                var isi = button.data('isi')
                var modal = $(this)
                modal.find('.modal-text').text('Hapus RAB ' + isi + ' ?')
                document.getElementById('formHapusUnit').action = 'hapusRABUnit/' + id;
            })
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#modalEditUnit').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var id = button.data('id') // Extract info from data-* attributes
                var isi = button.data('isi')
                var kode = button.data('kode')
                var jenis = button.data('jenis')
                var volume = button.data('volume')
                var satuan = button.data('satuan')
                var hargaSatuan = button.data('harga')
                var total = button.data('total')
                document.getElementById('formEditUnit').action = 'editRABUnit/' + id;
                $('#isiEditUnit').val(isi);
                $('#kodeEditUnit').val(kode);
                $('#volumeEditUnit').val(volume);
                $('#hargaSatuanEditUnit').val(hargaSatuan);
                if (jenis == 'kavling') {
                    $("#jenisKavling").prop("checked", true);
                }
                if (jenis == 'rumah') {
                    $("#jenisRumah").prop("checked", true);
                }
                if (jenis == 'kios') {
                    $("#jenisKios").prop("checked", true);
                }
            })
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#exampleModalCenter').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var id = button.data('id') // Extract info from data-* attributes
                var isi = button.data('isi')
                var modal = $(this)
                modal.find('.modal-text').text('Hapus RAB ' + isi + ' ?')
                document.getElementById('formHapus').action = 'hapusRAB/' + id;
            })
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#modalEdit').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var id = button.data('id') // Extract info from data-* attributes
                var isi = button.data('isi')
                var kode = button.data('kode')
                var volume = button.data('volume')
                var satuan = button.data('satuan')
                var hargaSatuan = button.data('harga')
                var total = button.data('total')
                document.getElementById('formEdit').action = 'editRAB/' + id;
                $('#isiEdit').val(isi);
                $('#volumeEdit').val(volume);
                $('#satuanEdit').val(satuan);
                $('#hargaSatuanEdit').val(hargaSatuan);
                $('#kodeRABEdit').val(kode);
                $('#totalEdit').val(total);
            })
        });
    </script>
    <script src="{{ mix('js/cleave.min.js') }}"></script>
    <script>
        var cleave = new Cleave('.hargaSatuanEdit', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        });
    </script>
    <script>
        function hitung2() {
            var hargaSatuan = parseInt((document.getElementById('hargaSatuanEdit').value).replace(/,/g, ''));
            var volume = document.getElementById('volumeEdit').value;
            var check = volume.includes("%");
            if (check == true) {
                var regex = /\d+/;
                var trim = volume.match(regex);
                var total = (trim * hargaSatuan) / 100;

            } else {
                var total = volume * hargaSatuan;
            }
            document.getElementById('totalEdit').value = total;
            var cleave = new Cleave('.totalEdit', {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand'
            });
        }
    </script>
@endsection
