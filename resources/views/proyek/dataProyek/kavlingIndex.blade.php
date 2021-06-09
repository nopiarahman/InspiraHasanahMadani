@extends('layouts.tema')
@section ('menuKavling','active')
@section ('menuDataProyek','active')
@section('content')
<div class="section-header">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>Unit</h1>
        </div>
      </div>
      <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb  bg-white mb-n2">
            <li class="breadcrumb-item" aria-current="page"> Unit </li>
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
          <h4>Tambah Unit Baru</h4>
        </div>
        <div class="card-body">
        <form action="{{route('kavlingSimpan')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Blok</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('blok') is-invalid @enderror" placeholder="ditulis dengan urutan blok diikuti nomor rumah" name="blok" value="{{old('blok')}}">
              @error('blok')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Luas</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('luas') is-invalid @enderror" placeholder="ditulis angka tanpa keterangan meter (m)" name="luas" value="{{old('luas')}}">
              @error('luas')
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
<!-- Modal Hapus-->
<div class="modal fade exampleModalCenter" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Hapus Unit</h5>
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
  <div class="card">
    <div class="card-header">
      <h4>Daftar Unit</h4>
    </div>
    <div class="card-body">
      <table class="table table-sm table-hover">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Blok</th>
            <th scope="col">Luas Tanah</th>
            <th scope="col">Luas Bangunan</th>
            <th scope="col">Kepemilikan</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($perBlok as $judul=>$semuaKavling)
          <tr>
            <th colspan="6" class="bg-light">Blok {{$judul}}</th>
          </tr>
          @foreach($semuaKavling as $kavling)
          <tr>
            <th scope="row">{{$loop->iteration}}</th>
            <td>{{$kavling->blok}}</td>
            <td>{{$kavling->luas}}m</td>
            <td>
              @if($kavling->rumah != null)
              {{$kavling->rumah->luasBangunan}}m
              @elseif($kavling->kios !=null)
              {{$kavling->kios->luasBangunan}}m
              @else
              -
              @endif
            </td>
            @if($kavling->pembelian == !null)
            <td>
              <a href="{{route('pelangganDetail',['id'=>$kavling->pembelian->pelanggan->id])}}" class="text-primary">
                {{$kavling->pembelian->pelanggan->nama}}
              </a>
            </td>
            @else
            <td>-</td>
            @endif
            <td>
              {{-- <a href="{{route('proyekEdit',['id'=>$kavling->id])}}" class="badge badge-info">Edit</a> --}}
              <button type="button" class="btn btn-sm btn-white text-primary" 
              data-toggle="modal" 
              data-target="#modalEdit" 
              data-id="{{$kavling->id}}" 
              data-blok="{{$kavling->blok}}" 
              data-luas="{{$kavling->luas}}">
              <i class="fa fa-pen" aria-hidden="true" ></i> Edit</button>

              <button type="button" class="btn btn-sm btn-white text-warning" 
              data-toggle="modal" 
              data-target="#exampleModalCenter" 
              data-id="{{$kavling->id}}" 
              data-blok="{{$kavling->blok}}">
              <i class="fa fa-trash" aria-hidden="true" ></i> Hapus</button>
            </td>
          </tr>
          @endforeach
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="modal fade modalEdit bd-example-modal-lg ml-5" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Edit Unit</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="POST" enctype="multipart/form-data" id="formEdit">
            @method('patch')
            @csrf
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Blok</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('blok') is-invalid @enderror" name="blok" value="" id="blokEdit">
                @error('blok')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Luas Tanah</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('luas') is-invalid @enderror" name="luas" value="" id="luasEdit">
                @error('luas')
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
      $('#modalEdit').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var blok = button.data('blok') 
      var luas = button.data('luas') 
      var id = button.data('id') 
      document.getElementById('formEdit').action='editKavling/'+id;
      $('#blokEdit').val(blok);
      $('#luasEdit').val(luas);
      })

      $(document).ready(function () {
      $('#exampleModalCenter').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var id = button.data('id') // Extract info from data-* attributes
      var blok = button.data('blok') 
      var modal = $(this)
      modal.find('.modal-text').text('Hapus Unit ' + blok+' ?')
      document.getElementById('formHapus').action='hapusKavling/'+id;
      })
    });
    });
    </script>
@endsection