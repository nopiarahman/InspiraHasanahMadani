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
        <div class="kanan">
          <a href="{{route('cetakRABUnit')}}" class="btn btn-primary"> <i class="fas fa-file-excel"></i> Export Excel</a>
        </div>
      </div>
      <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb  bg-white mb-n2">
            <li class="breadcrumb-item"> <a href="{{route('RAB')}}"> RAB </a></li>
            <li class="breadcrumb-item" aria-current="page"> Biaya Unit </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
  <div class="section-header">
    <a href="{{route('RAB')}}"  class="btn btn-primary  ">RAB</a>
    <a href="{{route('biayaUnit')}}" class="btn btn-primary ml-2 disabled">Biaya Unit</a>
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
    @if(auth()->user()->role=="admin")
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Tambah Jenis Biaya Unit</h4>
          </div>
          <div class="card-body">
          <form action="{{route('rabUnitSimpan')}}" method="POST" enctype="multipart/form-data">
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
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis</label>
              <div class="col-sm-12 col-md-7">
                <label class="selectgroup-item">
                  <input type="radio" name="jenisUnit" value="kavling" class="selectgroup-input" checked="">
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
                <input type="text" class="hargaSatuan form-control @error('hargaSatuan') is-invalid @enderror" name="hargaSatuan" value="{{old('hargaSatuan')}}" id="hargaSatuan">
                @error('hargaSatuan')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <script src="{{ mix("js/cleave.min.js") }}"></script>
            <script>
                var cleave = new Cleave('.hargaSatuan', {
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
    <div class="row">
      <div class="col-12 col-md-8 col-lg-8">
        <div class="card-header">
          <h4>Biaya Unit</h4>
        </div>
      </div>
      <div class="col-12 col-md-3 col-lg-3 align-right">
        {{-- <div class="card-header"> --}}
          <p class="text-card text-primary">Jumlah Unit Kavling     : {{hitungUnit(null,null,'kavling')}}</p> 
          <p class="text-card text-primary">Jumlah Unit Rumah       : {{hitungUnit(null,null,'rumah')}}</p> 
        {{-- </div> --}}
      </div>
    </div>
    <div class="card-body">
      <table class="table table-sm table-hover">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Biaya</th>
            <th scope="col">Jenis</th>
            <th scope="col">Volume</th>
            <th scope="col">Satuan</th>
            <th scope="col">Harga Satuan</th>
            <th scope="col">Total</th>
            <th scope="col">Pengeluaran</th>
            <th scope="col">Persentase</th>
          </tr>
        </thead>
        <tbody>
          @php
              $a=[];
              $b=[];
              $c=[];
              $totalIsi=[];
          @endphp
          @foreach($perHeader as $header=>$semuaRAB)
          <tr>
            <th colspan="9" class="bg-primary text-white">{{$loop->iteration}}. {{$header}}</th>
          </tr>
          @foreach($perJudul[$header] as $judul=>$semuaRAB)
          @php
              $a[$judul]=0;
              $c[$judul]=0;
              $totalIsi[$judul]=0;
          @endphp
          <tr>
            <th colspan="9" class="">{{$loop->iteration}}. {{$judul}}</th>
          </tr>
            @foreach($semuaRAB as $rab)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>{{$rab->isi}}</td>
              <td>{{$rab->jenisUnit}}</td>
              <td>{{hitungUnit($rab->isi,$rab->judul,$rab->jenisUnit)}}</td>
              <td>{{satuanUnit($rab->judul)}}</td>
              <td>Rp.{{number_format((int)$rab->hargaSatuan)}}</td>
              <th>Rp.{{number_format((hitungUnit($rab->isi,$rab->judul,$rab->jenisUnit))*(int)$rab->hargaSatuan)}}</th>
              @php
                  $totalIsi[$judul]=(hitungUnit($rab->isi,$rab->judul,$rab->jenisUnit))*(int)$rab->hargaSatuan+$totalIsi[$judul];
              @endphp
              <th > <a class="text-warning font-weight-bold" href="{{route('transaksiRABUnit',['id'=>$rab->id])}}"> Rp.{{number_format(hitungTransaksiRABUnit($rab->id))}}</a></th>
              <th>
                @if((int)$rab->hargaSatuan != 0)
                {{-- pengeluaran/total*100 --}}
                {{number_format((float)(hitungTransaksiRABUnit($rab->id)/(hitungUnit($rab->isi,$rab->judul,$rab->jenisUnit)*(int)$rab->hargaSatuan)*100),2)}}%
                
                @else
                -
                @endif
              </th>
            </tr>
            @endforeach
            @php
              $a[$judul]=$totalIsi[$judul]
            @endphp
            @php
                $c[$judul]=$a[$judul]-$c[$judul];
            @endphp
            <tr  class="border-top border-success">
              <th colspan="6" class="text-right " >Sub Total {{$judul}}</th>
              <th colspan="3" class="" >Rp. {{number_format($c[$judul])}}</th>
            </tr>
            @endforeach
              @php
                  $b[$header]=array_sum($c)-array_sum($b); /* menghitung total header */
              @endphp
            <tr>
              <th colspan="6" class=" bg-secondary text-right">TOTAL {{$header}}</th>
              <th colspan="3" class="bg-secondary " >Rp. {{number_format($b[$header])}}</th>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th colspan="6" class="text-white bg-warning text-right">TOTAL BIAYA UNIT</th>
              <th colspan="3" class="bg-warning text-white" >Rp. {{number_format(array_sum($b))}}</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

@endsection