@extends('layouts.tema')
@section ('menuProyekWeb','active')
@section('content')
<div class="section-header">
  <div class="container">
    <div class="row">
      <div class="col">
        <h1>Proyek</h1>
      </div>
    </div>
    <div class="row">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb  bg-white mb-n2">
          <li class="breadcrumb-item" aria-current="page"> Proyek </li>
        </ol>
      </nav>
    </div>
  </div>
</div>

<div class="section-header">
    <a href="{{route('proyekWebTambah')}}" class="btn btn-primary">Tambah Proyek Baru</a>
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

  {{-- Content --}}
<div class="card">
    <div class="card-header">
      <h4>Daftar Proyek</h4>
    </div>
    <div class="card-body">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Proyek</th>
            <th scope="col">Lokasi</th>
            <th scope="col">Proyek Start</th>
            <th scope="col">Publikasi</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($proyek as $pk)
          <tr>
            <th scope="row">{{$loop->iteration}}</th>
            <td>{{$pk->nama}}</td>
            <td>{{$pk->lokasi}}</td>
            <td>{{$pk->proyekStart}}</td>
            <td>{{$pk->status}}</td>
            <td><a href="{{route('proyekWebDetail',['id'=>$pk->id])}}" class="btn btn-sm btn-white text-primary border-success"> <i class="fas fa-pen    "></i> Detail</a>
              <button type="button" class="btn btn-sm btn-white text-danger border-danger" 
              data-toggle="modal" 
              data-target="#exampleModalCenter" 
              data-id="{{$pk->id}}" 
              data-nama="{{$pk->nama}}">
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
        <h5 class="modal-title" id="exampleModalLongTitle">Hapus Proyek</h5>
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
    <script>
          $(document).ready(function () {
      $('#exampleModalCenter').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var id = button.data('id') // Extract info from data-* attributes
      var nama = button.data('nama') 
      var modal = $(this)
      modal.find('.modal-text').text('Hapus Proyek ' + nama+' ?')
      document.getElementById('formHapus').action='proyekWebDelete/'+id;
      })
    });
    </script>
@endsection