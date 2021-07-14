@extends('layouts.tema')
@section ('menuRekening','active')
@section('content')
<div class="section-header sticky-top">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>Rekening</h1>
        </div>
      </div>
      <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb  bg-white mb-n2">
            <li class="breadcrumb-item" aria-current="page"> Rekening </li>
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
    @if(auth()->user()->role=="admin")
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Tambah Rekening Baru</h4>
          </div>
          <div class="card-body">
          <form action="{{route('rekeningSimpan')}}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group row mb-4" >
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bank</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('namaBank') is-invalid @enderror" name="namaBank" value="{{old('namaBank')}} " onchange="removeKategori()">
                @error('namaBank')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomor Rekening</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('noRekening') is-invalid @enderror" name="noRekening" value="{{old('noRekening')}}" id="noRekening">
                @error('noRekening')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Atas Nama</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('atasNama') is-invalid @enderror" name="atasNama" value="{{old('atasNama')}}">
                @error('atasNama')
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
  @endif
    <div class="card">
      <div class="card-header">
        <h4>Daftar Rekening</h4>
      </div>
      <div class="card-body">
        <table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Bank</th>
              <th scope="col">Nomor Rekening</th>
              <th scope="col">Atas Nama</th>
              @if(auth()->user()->role=="admin")
              <th scope="col">Aksi</th>
              @endif
            </tr>
          </thead>
          <tbody>
              @foreach($rekening as $item)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$item->namaBank}}</td>
                <td>{{$item->noRekening}}</td>
                <td>{{$item->atasNama}}</td>
                @if(auth()->user()->role=="admin")
                <td>
                  <button type="button" class="btn btn-sm btn-white text-primary border-success" 
                  data-toggle="modal" 
                  data-target="#modalEdit" 
                  data-id="{{$item->id}}" 
                  data-nama="{{$item->namaBank}}"
                  data-no="{{$item->noRekening}}" 
                  data-atas="{{$item->atasNama}}">
                  <i class="fa fa-pen" aria-hidden="true" ></i> Edit</button>

                  <button type="button" class="btn btn-sm btn-white text-danger border-danger" 
                  data-toggle="modal" 
                  data-target="#exampleModalCenter" 
                  data-id="{{$item->id}}" 
                  data-namaBank="{{$item->namaBank}}"
                  >
                  <i class="fa fa-trash" aria-hidden="true" ></i> Hapus</button>
                </td>
                @endif
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
        <h5 class="modal-title" id="exampleModalLongTitle">Hapus Rekening</h5>
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
<div class="modal fade modalEdit ml-5" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Rekening</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" enctype="multipart/form-data" id="formEdit">
          @method('patch')
          @csrf
          <div class="form-group row mb-4" >
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bank</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('namaBank') is-invalid @enderror" name="namaBank" value="{{old('namaBank')}} " id="namaBank2">
              @error('namaBank')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nomor Rekening</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('noRekening') is-invalid @enderror" name="noRekening" value="{{old('noRekening')}}" id="noRekening2">
              @error('noRekening')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Atas Nama</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('atasNama') is-invalid @enderror" name="atasNama" value="{{old('atasNama')}}" id="atasNama2">
              @error('atasNama')
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
  var namaBank = button.data('namaBank') 
  var modal = $(this)
  modal.find('.modal-text').text('Hapus Akun ' + namaBank+' ?')
  document.getElementById('formHapus').action='hapusRekening/'+id;
  })
});
</script>
<script type="text/javascript">
$(document).ready(function () {
  $('#modalEdit').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') // Extract info from data-* attributes
  var nama = button.data('nama') 
  console.log(nama);
  var no = button.data('no') 
  var atas = button.data('atas') 
  document.getElementById('formEdit').action='rekeningUbah/'+id;
  $('#namaBank2').val(nama);
  $('#noRekening2').val(no);
  $('#atasNama2').val(atas);
  })
});
</script>
  @endsection