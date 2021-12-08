@extends('layouts.tema')
@section ('menuGudang','active')
{{-- @section ('menuTransaksi','active') --}}
@section('content')
<div class="section-header sticky-top">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>Transaksi Gudang</h1>
        </div>
      </div>
      <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb  bg-white mb-n2">
            <li class="breadcrumb-item"> <a href="{{route('gudang')}}"> Transaksi Gudang </a></li>
            <li class="breadcrumb-item" aria-current="page"> Alokasi </li>
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
        @if (session('error'))
          <div class="alert alert-warning alert-dismissible show fade">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            {{session ('error')}}
          </div>
        @endif
      </div>
    </div>
    {{-- @if(auth()->user()->role=="admin") --}}
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Tambah Alokasi Untuk {{$id->jenisBarang}}</h4>
        </div>
        <div class="card-body">
        <form action="{{route('alokasiSimpan')}}" method="POST" enctype="multipart/form-data" onchange="hitung2()">
          @csrf
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal</label>
            <div class="col-sm-12 col-md-7">
              <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{old('tanggal')}}" >
              @error('tanggal')
              <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          {{-- <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kode Akun</label>
            <div class="input-group col-sm-12 col-md-7">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#pilihAkun">Pilih Akun</a>
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Akun</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" readonly class="form-control" name="" id="isiNamaAkun" value="{{old('isiNamaAkun')}}">
            </div>
          </div> --}}
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori RAB</label>
            <div class="input-group col-sm-12 col-md-7">
              <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#pilihRAB">Pilih RAB</a>
              <div class="input-group-prepend mx-3 mt-1">
                {{-- <div class="input-group-text " style="border: none"> --}}
                  atau
                {{-- </div> --}}
              </div>
              <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#pilihRABUnit">Pilih Biaya Unit</a>
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" hidden class="form-control" name="rab_id" id="idRAB" >
              <input type="text" hidden class="form-control" name="rabunit_id" id="idRABUnit" >
              {{-- <input type="text" hidden class="form-control" name="akun_id" id="idAkunCari" > --}}
              <input type="text" hidden class="form-control" name="gudang_id" value="{{$id->id}}" >
              <input type="text" readonly class="form-control" name="" id="isiRAB" value="{{old('isi')}}">
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Uraian</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('uraian') is-invalid @enderror" name="uraian" value="{{old('uraian')}}">
              @error('uraian')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Sisa Barang</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" readonly class="form-control @error('uraian') is-invalid @enderror" name="" value="{{$id->sisa}}">
              @error('sisaBarang')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jumlah Alokasi</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control jumlah @error('uraian') is-invalid @enderror" name="jumlah" value="{{old('jumlah')}}" id="jumlahBarang" max="{{$id->sisa}}">
              @error('jumlah')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>

          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Satuan</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" readonly class="form-control @error('uraian') is-invalid @enderror" name="satuan" value="{{$id->satuan}}">
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
              <input type="text" readonly class="form-control hargaSatuan @error('hargaSatuan') is-invalid @enderror" name="hargaSatuan" value="{{$id->harga}}" id="hargaSatuan">
              @error('hargaSatuan')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nominal Alokasi</label>
            <div class="input-group col-sm-12 col-md-7">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  Rp
                </div>
              </div>
              <input type="text" readonly class="form-control totalHarga @error('total') is-invalid @enderror" name="total" value="{{old('total')}}" id="totalHarga">
              @error('total')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
            <div class="col-sm-12 col-md-7">
              <button class="btn btn-primary" type="submit">Alokasi</button>
            </div>
          </div>
        </div>
      </form>
      <script>
        function hitung2(){
        var harga = parseInt((document.getElementById('hargaSatuan').value).replace(/,/g, ''));
        var banyaknya = parseFloat((document.getElementById('jumlahBarang').value).replace(/,/g, ''));
        var total = harga*banyaknya;
        $('#totalHarga').val(total);
        var cleave = new Cleave('.totalHarga', {
          numeral: true,
          numeralThousandsGroupStyle: 'thousand'
          });
        }
      
      </script>
      </div>
    </div>
  </div>
  {{-- @endif --}}
  <div class="card">
    <div class="card-header">
      <h4>Daftar Alokasi</h4>
    </div>
    <div class="card-body">
      
      <table class="table table-sm table-hover table-striped mt-3">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Kode Transaksi</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Uraian</th>
            <th scope="col">Jumlah Alokasi</th>
            <th scope="col">Nominal Alokasi</th>
            @if(auth()->user()->role=="admin")
            <th scope="col">Aksi</th>
            @endif
          </tr>
        </thead>
        <tbody>
          @forelse ($id->alokasiGudang as $alokasi)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>
                @if($alokasi->rab)
                {{$alokasi->rab->kodeRAB}}
                @elseif($alokasi->rabUnit)
                {{$alokasi->rabUnit->kodeRAB}}
                @endif
              </td>
              <td>{{formatTanggal($alokasi->tanggal)}}</td>
              <td>{{$alokasi->uraian}}</td>
              <td>{{$alokasi->jumlah}} {{$alokasi->satuan}}</td>
              <td>Rp. {{number_format($alokasi->debet)}}</td>
              @if(auth()->user()->role=="admin")
              <td>
                <button type="button" class="btn btn-sm btn-white text-danger border-danger" 
              data-toggle="modal" 
              data-target="#hapusTransaksi" 
              data-id="{{$alokasi->id}}" 
              data-uraian="{{$alokasi->uraian}}">
              <i class="fa fa-trash" aria-hidden="true" ></i> Hapus</button>
              </td>
              @endif
            </tr>
          @empty
            <tr>
              <td>

                Belum Ada Alokasi
              </td>
            </tr>
          @endforelse
          
          {{-- @foreach($transaksiKeluar as $transaksi)
          <tr>
            <td>{{formatTanggal($transaksi->tanggal)}}</td>
            <td>{{$transaksi->akun->kodeAkun}}</td>
            <td>{{$transaksi->uraian}}</td>
            <td>Rp.{{number_format($transaksi->debet)}}</td>
            <td>{{$transaksi->sumber}}</td>
            <td>
              @if (cekGudang($transaksi->id) == true)
              
              <a href="{{route('gudang')}}" type="button" class="btn btn-sm btn-white text-primary border-success">
              <i class="fas fa-warehouse "></i> Ada Stok Gudang</a>
              @else
              <button type="button" class="btn btn-sm btn-white text-primary border-success" 
              data-toggle="modal" 
              data-target="#keGudang" 
              data-id="{{$transaksi->id}}" 
              data-tanggal="{{$transaksi->tanggal}}" 
              data-uraian="{{$transaksi->uraian}}" 
              data-jumlah="{{$transaksi->jumlah}}" 
              data-satuan="{{$transaksi->satuan}}" 
              data-harga="{{$transaksi->hargaSatuan}}" 
              data-total="{{$transaksi->debet}}" 
              data-akun="{{$transaksi->akun->id}}" 
              data-awal="{{$transaksi->akun->namaAkun}}" 
              >
              Sisa Barang</button>
              @endif
              <button type="button" class="btn btn-sm btn-white text-danger border-danger" 
              data-toggle="modal" 
              data-target="#hapusTransaksi" 
              data-id="{{$transaksi->id}}" 
              data-uraian="{{$transaksi->uraian}}">
              <i class="fa fa-trash" aria-hidden="true" ></i> Hapus</button>
            </td>
          @endforeach --}}
        </tbody>
        <tfoot>
          <tr>
            <th colspan="3" class="text-right text-primary">Total Transaksi</th>
            {{-- <th colspan="2" class="text-primary">Rp. {{number_format($transaksiKeluar->sum('debet'))}}</th> --}}
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

      <!-- Modal Hapus-->
      <div class="modal fade hapusTransaksi" id="hapusTransaksi" tabindex="-1" role="dialog" aria-labelledby="hapusTransaksiTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Hapus Transaksi</h5>
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
                <button type="submit" class="btn btn-danger">Hapus!</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <script type="text/javascript">
        $(document).ready(function(){
          $('#hapusTransaksi').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var id = button.data('id') // Extract info from data-* attributes
          var uraian = button.data('uraian') 
          var modal = $(this)
          modal.find('.modal-text').text('Yakin ingin menghapus transaksi ' + uraian+' ?')
          document.getElementById('formHapus').action='/hapusAlokasi/'+id;
          })
        });
      </script>
  {{-- modal RAB--}}
  <div class="modal fade" id="pilihRAB" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pilih RAB</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="body table-responsive-xl">
            <table class="table table-sm table-hover">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Biaya</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($perHeader as $header=>$semuaRAB)
                <tr>
                  <th colspan="6" class="bg-primary text-light">{{$loop->iteration}}. {{$header}}</th>
                </tr>
                @foreach($perJudul[$header] as $judul=>$semuaRAB)
                <tr>
                  <th colspan="6" class="bg-light">{{$loop->iteration}}. {{$judul}}</th>
                </tr>
                  @foreach($semuaRAB as $rab)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td id="isiRAB">{{$rab->isi}}</td>
                    <td>
                      <a href="#" class="badge badge-info pilihRAB" data-id-rab={{$rab->id}} data-isi="{{$rab->isi}}" id="rab" >Pilih</a>
                    </td>
                  </tr>
                  @endforeach
                  @endforeach
                  @endforeach
                </tbody>
            </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          </form>  
        </div>
      </div>
    </div>
  </div>
  {{-- modal biaya Unit --}}
  <div class="modal fade " id="pilihRABUnit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pilih Biaya Unit</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="body table-responsive-xl">
            <table class="table table-sm table-hover">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Biaya</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($perHeaderUnit as $header=>$semuaRABUnit)
                <tr>
                  <th colspan="6" class="bg-primary text-light">{{$loop->iteration}}. {{$header}}</th>
                </tr>
                @foreach($perJudulUnit[$header] as $judul=>$semuaRABUnit)
                <tr>
                <th colspan="6" class="bg-light">{{$loop->iteration}}. {{$judul}}</th>
                </tr>
                  @foreach($semuaRABUnit->sortBy('isi',SORT_NATURAL) as $rab)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$rab->isi}}</td>
                    <td>
                      <a href="#" class="badge badge-info pilihRAB" data-id-unit={{$rab->id}} data-isi="{{$rab->isi}}" id="rabUnit" >Pilih</a>
                    </td>
                  </tr>
                  @endforeach
                  @endforeach
                  @endforeach
                </tbody>
            </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          </form>  
        </div>
      </div>
    </div>
  </div>
  {{-- modal Akun--}}
  {{-- <div class="modal fade " id="pilihAkun" tabindex="-1"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pilih Akun</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="body table-responsive-xl">
            <table class="table table-sm table-hover">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Kode Akun</th>
                  <th scope="col">Nama</th>
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
                    <td>
                      <a href="#" class="badge badge-info pilihRAB" data-id-akun={{$kategori->id}} data-isi="{{$kategori->namaAkun}}" id="akun" >Pilih</a>
                    </td>
                  </tr>
                  @endforeach
                @endforeach
              </tbody>
            </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          </form>  
        </div>
      </div>
    </div>
  </div> --}}
  <script>
    function hitung(){
    var harga = parseInt((document.getElementById('harga').value).replace(/,/g, ''));
    var banyaknya = document.getElementById('banyaknya').value;
    var total = harga*banyaknya;
    $('#total').val(total);
    }
  
  </script>
  <script type="text/javascript">

    $(document).ready(function(){
      $(document).on('click','#rab',function(){
        var idRab = $(this).data('idRab');
        var isi =$(this).data('isi');
        $('#idRAB').val(idRab);
        $('#idRABUnit').val("");
        // console.log(idRab);
        $('#isiRAB').val(isi);
        $('.close').click(); 
      });
      $(document).on('click','#rabUnit',function(){
        var idUnit = $(this).data('idUnit');
        var isi =$(this).data('isi');
        $('#idRAB').val("");
        $('#idRABUnit').val(idUnit);
        // console.log(idUnit);
        $('#isiRAB').val(isi);
        $('.close').click(); 
      });
      $(document).on('click','#akun',function(){
        var idAkun = $(this).data('idAkun');
        var isi =$(this).data('isi');
        $('#idAkunCari').val(idAkun);
        console.log(idAkun);
        $('#isiNamaAkun').val(isi);
        $('.close').click(); 
      });
    });

</script>
<script src="{{ mix("js/cleave.min.js") }}"></script>
<script>
  var cleave = new Cleave('.hargaSatuan', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
  });

</script>
  @endsection