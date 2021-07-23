@extends('layouts.tema')
@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section ('menuPengadaan','active')
@section ('menuDaftarPengadaan','active')
@section('content')
<div class="section-header sticky-top">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>Daftar Pengadaan</h1>
        </div>
      </div>
      <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb  bg-white mb-n2">
            <li class="breadcrumb-item" aria-current="page"> Daftar Pengadaan </li>
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

    <div class="row">
      <div class="col-12">
        {{-- <div class="card">
          <div class="card-header">
            <h4>Tambah Akun Baru</h4>
          </div>
          <div class="card-body">
          <form action="{{route('akunSimpan')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis</label>
              <div class="col-sm-12 col-md-7">
                <select class="form-control selectric" tabindex="-1" name="jenis" >
                  <option value="Produksi">Biaya Produksi</option>
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
        </div> --}}
        @if(auth()->user()->role=="admin")
        <div class="section-header">
          <button type="button" class="btn btn-primary" 
          data-toggle="modal" 
          data-target="#tambahPengadaan"
          <i class="fa fa-trash" aria-hidden="true" ></i> Tambah Pengadaan Baru</button>
        </div>
          @endif
      </div>
    </div>
  
    <div class="card">
      <div class="card-header">
        <h4>Daftar Pengadaan</h4>
      </div>
      <div class="card-body">
        <table class="table table-responsive-sm table-hover" id="table">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Tanggal</th>
              <th scope="col">Yang Mengajukan</th>
              <th scope="col">Deskripsi</th>
              <th scope="col">Status</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
              @foreach($semuaPengadaan as $pengadaan)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$pengadaan->tanggal}}</td>
                <td>{{$pengadaan->yangMengajukan}}</td>
                <td>{{$pengadaan->deskripsi}}</td>
                <td>
                  @if($pengadaan->status==0)
                    <span class="badge badge-primary">Belum Diperiksa</span>
                  @elseif($pengadaan->status==1)
                    <span class="badge badge-info text-white">Sudah Diperiksa</span>
                  @endif
                </td>
                <td>
                  @if(auth()->user()->role=="admin")
                  <a href="{{route('isiPengadaan',['id'=>$pengadaan->id])}}" class="btn btn-white border-success text-primary"> <i class="fas fa-pen    "></i> Isi Pengadaan </a>
                  @elseif(auth()->user()->role=='projectmanager')
                  <a href="{{route('isiPengadaan',['id'=>$pengadaan->id])}}" class="btn btn-white border-success text-primary"> <i class="fas fa-pen    "></i> Periksa </a>
                  @endif
                </td>
              </tr>
              @endforeach
          </tbody>
        </table>
      </div>
    </div>
{{-- modal Tambah Pengadaan --}}
<div class="modal fade tambahPengadaan bd-example-modal-lg ml-5" id="tambahPengadaan" tabindex="-1" role="dialog" aria-labelledby="tambahPengadaanTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Pengadaan Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('pengadaanSimpan')}}" method="post" enctype="multipart/form-data">
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
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Yang Mengajukan</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('yangMengajukan') is-invalid @enderror" name="yangMengajukan" value="" >
              @error('yangMengajukan')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" value="" >
              @error('deskripsi')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
            <div class="col-sm-12 col-md-7">
              <button class="btn btn-primary" type="submit">Simpan</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
          </div>
        </form>
        </div>
    </div>
  </div>
</div>
<!-- Modal Hapus-->
<div class="modal fade exampleModalCenter" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Hapus Akun</h5>
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
<div class="modal fade modalEdit bd-example-modal-lg ml-5" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Akun</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" enctype="multipart/form-data" id="formEdit">
          @method('patch')
          @csrf
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kode Akun</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('kodeAkun') is-invalid @enderror" name="kodeAkun" value="" id="kodeEdit">
              @error('kodeAkun')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Akun</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('namaAkun') is-invalid @enderror" name="namaAkun" value="" id="namaEdit">
              @error('namaAkun')
                <div class="invalid-feedback">{{$message}}</div>
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

<script type="text/javascript">
$(document).ready(function () {
  $('#exampleModalCenter').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') // Extract info from data-* attributes
  var nama = button.data('nama') 
  var modal = $(this)
  modal.find('.modal-text').text('Hapus Akun ' + nama+' ?')
  document.getElementById('formHapus').action='hapusAkun/'+id;
  })
});
</script>
<script type="text/javascript">
$(document).ready(function () {
  $('#modalEdit').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') // Extract info from data-* attributes
  var nama = button.data('nama') 
  var kode = button.data('kode') 
  var jenis = button.data('jenis') 
  var kategori = button.data('kategori')
  document.getElementById('formEdit').action='editAkun/'+id;
  $('#kodeEdit').val(kode);
  $('#namaEdit').val(nama);
  $('#editJenis').val(jenis);
  })
});
</script>
  @endsection
  @section('script')
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
  <script type="text/javascript" >
      $('#table').DataTable({
        "pageLength":     25,
        "language": {
          "decimal":        "",
          "emptyTable":     "Tidak ada data tersedia",
          "info":           "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
          "infoEmpty":      "Menampilkan 0 sampai 0 dari 0 data",
          "infoFiltered":   "(difilter dari _MAX_ total data)",
          "infoPostFix":    "",
          "thousands":      ",",
          "lengthMenu":     "Menampilkan _MENU_ data",
          "loadingRecords": "Loading...",
          "processing":     "Processing...",
          "search":         "Cari:",
          "zeroRecords":    "Tidak ada data ditemukan",
          "paginate": {
              "first":      "Awal",
              "last":       "Akhir",
              "next":       "Selanjutnya",
              "previous":   "Sebelumnya"
          },
          }
      });
  </script>
  @endsection