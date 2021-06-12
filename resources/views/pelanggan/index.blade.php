@extends('layouts.tema')
@section ('menuPelanggan','active')
@section('content')
<div class="section-header">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>Pelanggan</h1>
        </div>
      </div>
      <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb  bg-white mb-n2">
            <li class="breadcrumb-item" aria-current="page"> Pelanggan </li>
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
  
  <div class="section-header">
      <a href="{{route('pelangganTambah')}}" class="btn btn-primary">Tambah Pelanggan Baru</a>
  </div>
  
    {{-- Content --}}
  <div class="card">
      <div class="card-header">
        <h4>Daftar Pelanggan</h4>
      </div>
      <div class="card-body">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama</th>
              <th scope="col">Blok</th>
              <th scope="col">Jenis</th>
              <th scope="col">No Telp</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($semuaPelanggan as $pelanggan)
            <tr>
              <th scope="row">{{$loop->iteration}}</th>
              <td>{{$pelanggan->nama}}</td>
              @if($pelanggan->kavling==null)
              <td>Batal Akad</td>
              @else
              <td>{{$pelanggan->kavling->blok}}</td>
              @endif
              @if($pelanggan->kavling==null)
              <td>Batal Akad</td>
              @else
              {{-- <td>{{$pelanggan->kavling->blok}}</td> --}}
              <td>{{jenisKepemilikan($pelanggan->id)}}</td>
              @endif
              <td>{{$pelanggan->nomorTelepon}}</td>
              <td>
                <a href="{{route('pelangganDetail',['id'=>$pelanggan->id])}}" class="btn btn-white text-primary border-success btn-sm">Detail</a>
                <button type="button" class="btn btn-sm btn-white text-danger border-danger" 
                data-toggle="modal" 
                data-target="#exampleModalCenter" 
                data-id="{{$pelanggan->id}}" 
                data-nama="{{$pelanggan->nama}}">
                <i class="fa fa-trash" aria-hidden="true" ></i> Hapus</button>      
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {{$semuaPelanggan->links()}}
      </div>
    </div>
    <!-- Modal Hapus-->
    <div class="modal fade exampleModalCenter" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Batal Akad</h5>
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
        $('#exampleModalCenter').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id') // Extract info from data-* attributes
        var nama = button.data('nama') 
        var modal = $(this)
        modal.find('.modal-text').text('Yakin ingin menghapus pelanggan atas nama ' + nama+' ?')
        document.getElementById('formHapus').action='/hapusPelanggan/'+id;
        })
      });
    </script>
  @endsection