@extends('layouts.tema')
@section ('menuPelanggan','active')

@section('head')

@endsection

@section('content')
<div class="section-header sticky-top">
  <div class="container">
    <div class="row">
      <div class="col">
        <h1>Pelanggan</h1>
      </div>
    </div>
    <div class="row">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb  bg-white mb-n2">
          <li class="breadcrumb-item"><a href="{{route('pelangganIndex')}}"> Pelanggan </a></li>
          <li class="breadcrumb-item" aria-current="page"> Tambah </li>
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
  {{-- Form --}}
  <div class="containercostum">
    <div class="row">
      <div class="col-12">
        <div class="card ">
          <div class="card-header">
            <h4>Tambah Pelanggan Baru</h4>
          </div>
          <form action="{{route('pelangganSimpan')}}" method="POST" enctype="multipart/form-data" onchange="hitung()">
            {{-- Part 1 --}}
            <div class="card-body" id="pertama">
              @csrf
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Lengkap</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{old('nama')}}">
                  @error('nama')
                  <div class="invalid-feedback">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
                <div class="col-sm-12 col-md-7">
                  <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}">
                  @error('email')
                  <div class="invalid-feedback">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tempat & Tanggal Lahir</label>
                <div class="col-sm-6 col-md-3">
                  <input type="text" class="form-control @error('tempatLahir') is-invalid @enderror" name="tempatLahir" value="{{old('tempatLahir')}}">
                  @error('tempatLahir')
                  <div class="invalid-feedback">{{$message}}</div>
                  @enderror
                </div>
                <div class="col-sm-6 col-md-4">
                  <input type="date" class="form-control @error('tanggalLahir') is-invalid @enderror" name="tanggalLahir" value="{{old('tanggalLahir')}}">
                  @error('tanggalLahir')
                  <div class="invalid-feedback">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alamat</label>
                <div class="col-sm-12 col-md-7">
                  <input type="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{old('alamat')}}">
                  @error('alamat')
                  <div class="invalid-feedback">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis Kelamin</label>
                <div class="col-sm-12 col-md-7">
                  <label class="selectgroup-item">
                    <input type="radio" name="jenisKelamin" value="Laki-laki" class="selectgroup-input" checked="">
                    <span class="selectgroup-button">Laki-laki</span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="jenisKelamin" value="Perempuan" class="selectgroup-input">
                    <span class="selectgroup-button">Perempuan</span>
                  </label>
                  @error('jenisKelamin')
                  <div class="invalid-feedback">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status Pernikahan</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control @error('statusPernikahan') is-invalid @enderror" name="statusPernikahan" value="{{old('statusPernikahan')}}">
                  @error('statusPernikahan')
                  <div class="invalid-feedback">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pekerjaan</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" name="pekerjaan" value="{{old('pekerjaan')}}">
                  @error('pekerjaan')
                  <div class="invalid-feedback">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomor Telepon</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class=" input-phone form-control @error('nomorTelepon') is-invalid @enderror" name="nomorTelepon" value="{{old('nomorTelepon')}}">
                  @error('nomorTelepon')
                  <div class="invalid-feedback">{{$message}}</div>
                  @enderror
                </div>
              </div>
              
            </div>
            <div class="card-header ">
              <h4>  Data Unit</h4>
            </div>
            <div class="card-body" id="kedua">
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kavling</label>
                <div class="col-sm-12 col-md-7">
                  <select class="cari form-control" style="width:300px;height:calc(1.5em + .75rem + 2px);" name="kavling_id"></select>
                  {{-- <input type="text" class="form-control @error('objek') is-invalid @enderror" name="objek" value="{{old('objek')}}"> --}}
                  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
                  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
                  <script type="text/javascript">
                    $('.cari').select2({
                                        placeholder: 'Pilih Kavling...',
                                        ajax: {
                                        url: '/cariKavling',
                                        dataType: 'json',
                                        delay: 250,
                                        processResults: function (data) {
                                            return {
                                            results:  $.map(data, function (item) {
                                                return {
                                                text: item.blok, /* memasukkan text di option => <option>namaSurah</option> */
                                                id: item.id /* memasukkan value di option => <option value=id> */
                                                }
                                            })
                                            };
                                        },
                                        cache: true
                                        }
                                    });
                    </script>
                  @error('objek')
                  <div class="invalid-feedback">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomor Akad</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control @error('nomorAkad') is-invalid @enderror" name="nomorAkad" value="{{old('nomorAkad')}}" placeholder="kosongkan jika data belum ada">
                  
                  @error('nomorAkad')
                  <div class="invalid-feedback">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal Akad</label>
                <div class="col-sm-12 col-md-7">
                  <input type="date" class="form-control @error('tanggalAkad') is-invalid @enderror" name="tanggalAkad" value="{{old('tanggalAkad')}}" >
                  <div class="feedback mt-2">*kosongkan jika data belum ada</div>
                  @error('tanggalAkad')
                  <div class="invalid-feedback">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga</label>
                <div class="input-group col-sm-12 col-md-7">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      Rp
                    </div>
                  </div>
                  <input type="text" class="form-control harga" id="harga" name="harga">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Diskon</label>
                <div class="input-group col-sm-12 col-md-7">
                  <input type="text" class="form-control @error('diskon') is-invalid @enderror" name="diskon" value="{{old('diskon')}} " min="0" max="100" placeholder="diisi tanpa tanda %" id="diskon">
                  @error('diskon')
                  <div class="invalid-feedback">{{$message}}</div>
                  @enderror
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      %
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Total Diskon</label>
                <div class="input-group col-sm-12 col-md-7">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      Rp
                    </div>
                  </div>
                  <input type="text" readonly class="totalDiskon form-control @error('totalDiskon') is-invalid @enderror" name="totalDiskon" value="{{old('totalDiskon')}} " min="0" max="100" placeholder="diisi tanpa tanda %" id="totalDiskon">
                  @error('totalDiskon')
                  <div class="invalid-feedback">{{$message}}</div>
                  @enderror
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">DP</label>
                <div class="input-group col-sm-12 col-md-7">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      Rp
                    </div>
                  </div>
                  <input type="text" class="dp form-control @error('dp') is-invalid @enderror" name="dp"  id="dp">
                  @error('dp')
                  <div class="invalid-feedback">{{$message}}</div>
                  @enderror
                  
                  <div class="input-group-prepend">
                    <div class="input-group-text " style="border: none">
                      <label class="selectgroup-item " >
                        <input type="radio" name="statusDp" value="Credit" class="selectgroup-input" checked="">
                        <span class="selectgroup-button">Credit</span>
                      </label>
                      <label class="selectgroup-item ">
                        <input type="radio" name="statusDp" value="Cash" class="selectgroup-input">
                        <span class="selectgroup-button">Cash</span>
                      </label>
                      @error('statusDp')
                      <div class="invalid-feedback">{{$message}}</div>
                      @enderror
                    </div>
                  </div>
                    {{-- <div class="col-sm-12 col-md-4 input-group-text "> --}}
                      
                  {{-- </div> --}}
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Sisa Kewajiban</label>
                <div class="input-group col-sm-12 col-md-7">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      Rp
                    </div>
                  </div>
                  <input type="text" readonly class="sisaKewajiban form-control" name="sisaKewajiban" value="" id="sisaKewajiban">
                  
                  <div class="input-group-prepend">
                    <div class="input-group-text " style="border: none">
                      <label class="selectgroup-item " >
                        <input type="radio" name="statusCicilan" value="Credit" class="selectgroup-input" checked="" id="statusCicilanCredit">
                        <span class="selectgroup-button">Credit</span>
                      </label>
                      <label class="selectgroup-item ">
                        <input type="radio" name="statusCicilan" value="Cash" class="selectgroup-input" id="statusCicilanCash">
                        <span class="selectgroup-button">Cash</span>
                      </label>
                      @error('statusCicilan')
                      <div class="invalid-feedback">{{$message}}</div>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
              <div id="tenor" class="">
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tenor</label>
                  <div class="input-group col-sm-12 col-md-7">
                    <input type="number" class=" form-control @error('tenor') is-invalid @enderror" name="tenor" value="{{old('tenor')}} ">
                    @error('tenor')
                    <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        bulan
                      </div>
                    </div>
                    
                  </div>
                </div>
              </div>
              
            </div>
            {{-- button Form --}}
            <div class="card-footer">
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                <div class="col-sm-12 col-md-7">
                  <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
              </div>
            </div>
          </form>
    </div>
  </div>
</div>

</div>
@endsection

@section('script')
<script src="{{ mix("js/jquery.min.js") }}"></script>
<script>
  function hitung(){
  var harga = parseInt((document.getElementById('harga').value).replace(/,/g, ''));
  var diskon = parseInt((document.getElementById('diskon').value).replace(/,/g, ''));
  var dp = parseInt((document.getElementById('dp').value).replace(/,/g, ''));

  var totalDiskon = harga*diskon/100;
  if(isNaN(totalDiskon)){
    document.getElementById("totalDiskon").value =0;
    var kewajiban = harga-dp;
    }else{
    document.getElementById("totalDiskon").value = totalDiskon; 
    var cleave = new Cleave('.totalDiskon', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
    });
    var kewajiban = harga-dp-totalDiskon;
    }

    if(isNaN(kewajiban)){
      document.getElementById("sisaKewajiban").value =0;
    }else{
    document.getElementById("sisaKewajiban").value = kewajiban; 
    var cleave = new Cleave('.sisaKewajiban', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
    });
    }

    if(document.getElementById('statusCicilanCredit').checked){
      document.getElementById('tenor').style.display = 'block';
    }else{
      document.getElementById('tenor').style.display = 'none';
    }

    
    
  }

</script>
{{-- Install package --}}
{{-- npm install --save cleave.js --}}
{{-- dokumentasi https://nosir.github.io/cleave.js/ --}}
{{-- insert script dengan laravel Mix helper -- lokasi file webpack.mix.js -- run npm run dev setelah import--}}
<script src="{{ mix("js/cleave.min.js") }}"></script>
<script src="{{ mix("js/addons/cleave-phone.id.js") }}"></script>
<script>
  var cleave = new Cleave('.input-phone', {
    phone: true,
    phoneRegionCode: 'ID'
  });
  var cleave = new Cleave('.harga', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
  });
  var cleave = new Cleave('.dp', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
  });
  


</script>




@endsection