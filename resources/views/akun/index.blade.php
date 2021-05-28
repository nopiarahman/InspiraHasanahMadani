@extends('layouts.tema')
@section ('menuAkun','active')
@section('content')
<div class="section-header sticky-top">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>Akun</h1>
        </div>
      </div>
      <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb  bg-white mb-n2">
            <li class="breadcrumb-item" aria-current="page"> Akun </li>
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
          {{session ('status')}}
        </div>
      @endif
    </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Tambah Akun Baru</h4>
          </div>
          <div class="card-body">
          <form action="{{route('akunSimpan')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis</label>
              <div class="col-sm-12 col-md-7">
                <select class="form-control selectric" tabindex="-1" name="jenis" onchange="eventPendapatan()">
                  <option value="Operasional">Biaya Produksi</option>
                  <option value="Operasional">Biaya Operasional</option>
                  <option value="Non-Operasional">Biaya Non-Operasional</option>
                  <option value="Pendapatan Lain-lain">Pendapatan Lain-lain</option>
                  <option value="Modal">Modal</option>
                </select>
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori Akun</label>
              <div class="input-group col-sm-12 col-md-7">
                <div class="input-group-prepend">
                  <select name="kategoriLama" id="kategori" class="form-control kategoriAkun">
                  </select>
                </div>
                <div class="input-group-prepend">
                  <div class="input-group-text " style="border: none">
                    atau
                    <a class="btn btn-primary ml-3" onclick="inputBaru()">Kategori Baru</a>
                  </div>
                </div>
              </div>
            </div>
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
                  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
                  <script type="text/javascript">
                    $('.kategoriAkun').select2({
                                        placeholder: 'Pilih Kategori...',
                                        ajax: {
                                        url: '/cariAkun',
                                        dataType: 'json',
                                        delay: 250,
                                        processResults: function (data) {
                                            return {
                                            results:  $.map(data, function (item) {
                                                return {
                                                text: item.kategori, /* memasukkan text di option => <option>namaSurah</option> */
                                                id: item.kategori /* memasukkan value di option => <option value=id> */
                                                }
                                            })
                                            };
                                        },
                                        cache: true
                                        }
                                    });
                    </script>
            <script>
              function inputBaru(){
                var inputBaru = document.querySelector('.kategoriBaru');
                inputBaru.className ='form-group row mb-4 kategoriBaru';
              }
              document.getElementById("kategori").onchange = changeListener;
              function changeListener(){
                var value = this.value
                var inputBaru = document.querySelector('.kategoriBaru');
                console.log(value);
                if (value == "input"){
                  inputBaru.className ='form-group row mb-4 kategoriBaru';
                }else{
                  inputBaru.className ='form-group row mb-4 kategoriBaru d-none';
                }
              }
            </script>
            <div class="form-group row mb-4 kategoriBaru d-none" >
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Input Kategori Baru</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('kategoriBaru') is-invalid @enderror" name="kategori" value="{{old('kategoriBaru')}} " onchange="removeKategori()">
                @error('kategoriBaru')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <script>
              function removeKategori(){
                var select = document.getElementById("kategori");
                var length = select.options.length;
                for (i = length-1; i >= 0; i--) {
                  select.options[i] = null;
                }
              }
            </script>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kode Akun</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('kodeAkun') is-invalid @enderror" name="kodeAkun" value="{{old('kodeAkun')}}" id="kodeAkun">
                @error('kodeAkun')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Akun</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('namaAkun') is-invalid @enderror" name="namaAkun" value="{{old('namaAkun')}}">
                @error('namaAkun')
                  <div class="invalid-feedback">{{$message}}</div>
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
  
    <div class="card">
      <div class="card-header">
        <h4>Daftar Akun</h4>
      </div>
      <div class="card-body">
        <table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Kode Akun</th>
              <th scope="col">Nama Akun</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($perKategori as $judul=>$kategoriAkun)
            <tr>
              <th colspan="4" class="bg-light">{{$judul}}</th>
            </tr>
              @foreach($kategoriAkun as $kategori)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$kategori->kodeAkun}}</td>
                <td>{{$kategori->namaAkun}}</td>
              </tr>
              @endforeach
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  @endsection