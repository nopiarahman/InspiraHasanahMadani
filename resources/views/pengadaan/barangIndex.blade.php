@extends('layouts.tema')\
@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section ('menuPengadaan','active')
@section ('menuDaftarBarang','active')
@section('content')
<div class="section-header sticky-top">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>Daftar Barang</h1>
        </div>
      </div>
      <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb  bg-white mb-n2">
            <li class="breadcrumb-item" aria-current="page"> Daftar Barang </li>
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
        <div class="card">
          <div class="card-header">
            <h4>Tambah Barang Baru</h4>
          </div>
          <div class="card-body">
          <form action="{{route('barangSimpan')}}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Barang</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('namaBarang') is-invalid @enderror" name="namaBarang" value="{{old('namaBarang')}}" id="namaBarang">
                @error('namaBarang')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Merek</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" placeholder="kosongkan jika tidak memiliki merek" class="form-control @error('merek') is-invalid @enderror" name="merek" value="{{old('merek')}}">
                @error('merek')
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
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Estimasi Harga Satuan</label>
              <div class="input-group col-sm-12 col-md-7">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    Rp
                  </div>
                </div>
                <input type="text" class="form-control harga" id="harga" name="harga">
                @error('harga')
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
        <h4>Daftar Barang</h4>
      </div>
      <div class="card-body">
        <table class="table table-sm table-hover" id="table">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama Barang</th>
              <th scope="col">Merek</th>
              <th scope="col">Satuan</th>
              <th scope="col">Estimasi Harga Satuan</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
              @foreach($semuaBarang as $barang)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$barang->namaBarang}}</td>
                <td>{{$barang->merek}}</td>
                <td>{{$barang->satuan}}</td>
                <td>Rp.{{number_format($barang->harga)}}</td>
                <td>
                  <button type="button" class="btn btn-sm btn-white text-primary border-success" 
                  data-toggle="modal" 
                  data-target="#modalEdit" 
                  data-id="{{$barang->id}}" 
                  data-merek="{{$barang->merek}}" 
                  data-harga="{{$barang->harga}}" 
                  data-satuan="{{$barang->satuan}}" 
                  data-nama="{{$barang->namaBarang}}">
                  <i class="fa fa-pen" aria-hidden="true" ></i> Edit</button>

                  <button type="button" class="btn btn-sm btn-white text-danger border-danger" 
                  data-toggle="modal" 
                  data-target="#exampleModalCenter" 
                  data-id="{{$barang->id}}" 
                  data-nama="{{$barang->namaBarang}}">
                  <i class="fa fa-trash" aria-hidden="true" ></i> Hapus</button>
                </td>
              </tr>
              @endforeach
          </tbody>
        </table>
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
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Barang</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('namaBarang') is-invalid @enderror" name="namaBarang" value="{{old('namaBarang')}}" id="namaBarangEdit">
              @error('namaBarang')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Merek</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" placeholder="kosongkan jika tidak memiliki merek" class="form-control @error('merek') is-invalid @enderror" name="merek" value="{{old('merek')}}" id="merekEdit">
              @error('merek')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Satuan</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('satuan') is-invalid @enderror" name="satuan" value="{{old('satuan')}}" id="satuanEdit">
              @error('satuan')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Estimasi Harga Satuan</label>
            <div class="input-group col-sm-12 col-md-7">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  Rp
                </div>
              </div>
              <input type="text" class="form-control hargaEdit" name="harga" id="hargaEdit">
              @error('harga')
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
<script src="{{ mix("js/cleave.min.js") }}"></script>
<script src="{{ mix("js/addons/cleave-phone.id.js") }}"></script>
<script>
  var cleave = new Cleave('.harga', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
  });
</script>
<script>
  var cleave = new Cleave('.hargaEdit', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
  });
</script>
<script type="text/javascript">
$(document).ready(function () {
  $('#exampleModalCenter').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') // Extract info from data-* attributes
  var nama = button.data('nama') 
  var modal = $(this)
  modal.find('.modal-text').text('Hapus Barang ' + nama+' ?')
  document.getElementById('formHapus').action='hapusBarang/'+id;
  })
});
</script>
<script type="text/javascript">
$(document).ready(function () {
  $('#modalEdit').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') // Extract info from data-* attributes
  var barang = button.data('nama') 
  var merek = button.data('merek') 
  var satuan = button.data('satuan') 
  var harga = button.data('harga') 
  document.getElementById('formEdit').action='editBarang/'+id;
  $('#namaBarangEdit').val(barang);
  $('#merekEdit').val(merek);
  $('#hargaEdit').val(harga);
  $('#satuanEdit').val(satuan);
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