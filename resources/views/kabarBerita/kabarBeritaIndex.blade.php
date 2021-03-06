@extends('layouts.tema')
@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section ('menuKabarBerita','active')
@section('content')
<div class="section-header sticky-top">
  <div class="container">
    <div class="row">
      <div class="col">
        <h1>Kabar Berita</h1>
      </div>
    </div>
    <div class="row">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb  bg-white mb-n2">
          <li class="breadcrumb-item" aria-current="page"> Kabar Berita </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<div class="section-header">
  <a href="{{route('kabarBeritaTambah')}}" class="btn btn-primary">Tambah Berita</a>
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
    
<div class="card">
  <div class="card-header">
    <h4>Daftar Kabar Berita</h4>
  </div>
  <div class="card-body">
    <table class="table table-hover table-sm table-responsive-sm" id="table">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Judul</th>
          <th scope="col">Dibuat Oleh</th>
          <th scope="col">Tanggal</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($kabarBerita as $kb)
        <tr>
          <td>{{$loop->iteration}}</td>
          <td>{{$kb->judul}}</td>
          <td>{{$kb->author}}</td>
          <td>{{formatTanggal($kb->tanggal)}}</td>
          <td>
            <a href="{{route('lihatBerita',['id'=>$kb->id])}}" class="btn btn-sm text-success btn-white border-success">Lihat</a>
            <button type="button" class="btn btn-sm btn-white text-danger border-danger" 
            data-toggle="modal" 
            data-target="#exampleModalCenter" 
            data-id="{{$kb->id}}" 
            data-judul="{{$kb->judul}}">
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
        <h5 class="modal-title" id="exampleModalLongTitle">Hapus Berita</h5>
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
@endsection
@section('script')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script type="text/javascript" >
    $('#table').DataTable({
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
    $(document).ready(function () {
      $('#exampleModalCenter').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var id = button.data('id') // Extract info from data-* attributes
      var judul = button.data('judul') 
      var modal = $(this)
      modal.find('.modal-text').text('Hapus Berita ' + judul+' ?')
      document.getElementById('formHapus').action='hapusBerita/'+id;
      })
    });
</script>
@endsection