@extends('layouts.tema')
@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section ('menuPelanggan','active')
@section ('menupelangganTerhapus','active')
@section('content')
<div class="section-header">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>Pelanggan Terhapus</h1>
        </div>
      </div>
      <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb  bg-white mb-n2">
            <li class="breadcrumb-item" aria-current="page"> Pelanggan Terhapus</li>
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
    {{-- Content --}}
  <div class="card">
      <div class="card-header">
        <h4>Daftar Pelanggan Terhapus</h4>
      </div>
      <div class="card-body">
        <table class="table table-hover table-sm table-responsive-sm" id="table">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama</th>
              <th scope="col">No Telp</th>
              <th scope="col">Dihapus Pada</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($terhapus as $pelanggan)
            <tr>
              <th scope="row">{{$loop->iteration}}</th>
              <td>{{$pelanggan->nama}}</td>
              <td>{{$pelanggan->nomorTelepon}}</td>
              <td>{{$pelanggan->deleted_at}}</td>
              <td>
                @if(auth()->user()->role=="admin")
                <button type="button" class="btn btn-sm btn-white text-primary border-primary" 
                data-toggle="modal" 
                data-target="#exampleModalCenter" 
                data-id="{{$pelanggan->id}}" 
                data-nama="{{$pelanggan->nama}}">
                <i class="fa fa-undo" aria-hidden="true"></i> Restore</button>      
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {{-- {{$pelangganAktif->links()}} --}}
      </div>
    </div>
    <!-- Modal Hapus-->
    <div class="modal fade exampleModalCenter" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Kembalikan Pelanggan Ke Tidak Aktif?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" method="post" id="formHapus">
              @method('patch')
              @csrf
              <p class="modal-text"></p>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Restore!</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      $(document).ready(function(){
        $('#exampleModalCenter').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') // Extract info from data-* attributes
        var nama = button.data('nama') 
        var modal = $(this)
        modal.find('.modal-text').text('Yakin ingin mengembalikan pelanggan atas nama ' + nama+' ?')
        document.getElementById('formHapus').action='/restoreTerhapus/'+id;
        })
      });
    </script>
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
</script>
@endsection