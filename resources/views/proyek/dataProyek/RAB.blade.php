@extends('layouts.tema')
@section ('menuRAB','active')
@section ('menuDataProyek','active')
@section('content')
<div class="section-header">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>RAB</h1>
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
  <div class="section-header">
    <a href="{{route('RAB')}}"  class="btn btn-primary disabled ">RAB</a>
    <a href="{{route('biayaUnit')}}" class="btn btn-primary ml-2">Biaya Unit</a>
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
            <h4>Tambah Jenis Biaya Baru</h4>
          </div>
          <div class="card-body">
          <form action="{{route('biayaRABSimpan')}}" method="POST" enctype="multipart/form-data" onchange="hitung()">
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
            <div class="form-group row mb-4 headerBaru d-none" >
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Input Header Baru</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('headerBaru') is-invalid @enderror" name="header" value="{{old('headerBaru')}} " onchange="removeHeader()">
                @error('headerBaru')
                  <div class="invalid-feedback">{{$message}}</div>
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
                                        processResults: function (data) {
                                            return {
                                            results:  $.map(data, function (item) {
                                                return {
                                                text: item.header, /* memasukkan text di option => <option>namaSurah</option> */
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
              function inputBaru(){
                var inputBaru = document.querySelector('.headerBaru');
                inputBaru.className ='form-group row mb-4 headerBaru';
              }
              document.getElementById("header").onchange = changeListener;
              function changeListener(){
                var value = this.value
                var inputBaru = document.querySelector('.headerBaru');
                console.log(value);
                if (value == "input"){
                  inputBaru.className ='form-group row mb-4 headerBaru';
                }else{
                  inputBaru.className ='form-group row mb-4 headerBaru d-none';
                }
              }
            </script>

            <script>
              function removeHeader(){
                var select = document.getElementById("header");
                var length = select.options.length;
                for (i = length-1; i >= 0; i--) {
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
            <div class="form-group row mb-4 judulBaru d-none" >
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Input Judul Baru</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('judulBaru') is-invalid @enderror" name="judul" value="{{old('judulBaru')}} " onchange="removeJudul()">
                @error('judulBaru')
                  <div class="invalid-feedback">{{$message}}</div>
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
                                        processResults: function (data) {
                                            return {
                                            results:  $.map(data, function (item) {
                                                return {
                                                text: item.judul, /* memasukkan text di option => <option>namaSurah</option> */
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
              function inputJudulBaru(){
                var inputJudulBaru = document.querySelector('.judulBaru');
                inputJudulBaru.className ='form-group row mb-4 judulBaru';
              }
              document.getElementById("judul").onchange = changeListener;
              function changeListener(){
                var value = this.value
                var inputJudulBaru = document.querySelector('.judulBaru');
                console.log(value);
                if (value == "input"){
                  inputJudulBaru.className ='form-group row mb-4 judulBaru';
                }else{
                  inputJudulBaru.className ='form-group row mb-4 judulBaru d-none';
                }
              }
            </script>

            <script>
              function removeJudul(){
                var select = document.getElementById("judul");
                var length = select.options.length;
                for (i = length-1; i >= 0; i--) {
                  select.options[i] = null;
                }
              }
            </script>


            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Isi Biaya</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('isi') is-invalid @enderror" name="isi" value="{{old('isi')}}">
                @error('isi')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Volume</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('volume') is-invalid @enderror" name="volume" value="{{old('volume')}}" id="volume" placeholder="diisi dengan angka atau persen">
                @error('volume')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Satuan</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('satuan') is-invalid @enderror" name="satuan" value="{{old('satuan')}}">
                @error('satuan')
                  <div class="invalid-feedback">{{$message}}</div>
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
                <input type="text" class="form-control @error('hargaSatuan') is-invalid @enderror" name="hargaSatuan" value="{{old('hargaSatuan')}}" id="hargaSatuan">
                @error('hargaSatuan')
                  <div class="invalid-feedback">{{$message}}</div>
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
                <input readonly type="text" class="total form-control @error('total') is-invalid @enderror" name="total" value="{{old('total')}}" id="total">
                @error('total')
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
      <h4>RAB</h4>
    </div>
    <div class="card-body">
      <table class="table table-sm table-hover">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Biaya</th>
            <th scope="col">Volume</th>
            <th scope="col">Satuan</th>
            <th scope="col">Harga Satuan</th>
            <th scope="col">Total</th>
          </tr>
        </thead>
        <tbody>
          @php
              $a=[];
              $b=[];
          @endphp
          @foreach($perHeader as $header=>$semuaRAB)
          <tr>
            <th colspan="6" class="bg-primary text-light">{{$loop->iteration}}. {{$header}}</th>
          </tr>
          @foreach($perJudul[$header] as $judul=>$semuaRAB)
          <tr>
            <th colspan="6" class="">{{$loop->iteration}}. {{$judul}}</th>
          </tr>
            @foreach($semuaRAB as $rab)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>{{$rab->isi}}</td>
              <td>{{$rab->volume}}</td>
              <td>{{$rab->satuan}}</td>
              <td>Rp.{{number_format($rab->hargaSatuan)}}</td>
              <th>Rp.{{number_format($rab->total)}}</th>
            </tr>
            @endforeach
            <tr>
              <th colspan="5" class="text-right bg-secondary" >Sub Total {{$judul}}</th>
              <th class="bg-secondary" >Rp. {{number_format($semuaRAB->sum('total'))}}</th>
            </tr>
            @php
                $a[]=$semuaRAB->sum('total'); /* menghitung per total judul */
                @endphp
            @endforeach
            <tr>
              <th colspan="5" class="text-white bg-warning text-right">TOTAL {{$header}}</th>
              @php
                  $b[$header]=array_sum($a)-array_sum($b); /* menghitung total header */
                  @endphp
              <th class="bg-warning text-white" >Rp. {{number_format($b[$header])}}</th>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th colspan="5" class="text-white bg-danger text-right">TOTAL RAB</th>
              <th class="bg-danger text-white" >Rp. {{number_format(array_sum($b))}}</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
        {{-- {{$semuaKavling->links()}} --}}
        <script src="{{ mix("js/cleave.min.js") }}"></script>
        <script>
          function hitung(){
            
            var volume = document.getElementById('volume').value;
            var hargaSatuan = document.getElementById('hargaSatuan').value;
            var check = volume.includes("%");
            if(check == true){
              var regex = /\d+/;
              var trim = volume.match(regex);
              var total = (trim*hargaSatuan)/100;
              // var total = trim*hargaSatuan-persen;

            }else{
              var total = volume*hargaSatuan;
            }
            document.getElementById('total').value=total;
            var cleave = new Cleave('.total', {
              numeral: true,
              numeralThousandsGroupStyle: 'thousand'
            });
          }
        </script>
@endsection