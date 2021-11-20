@extends('layouts.tema')
@section ('menuProyek','active')
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
          <li class="breadcrumb-item"> <a href="{{route('proyek')}}"> Proyek</a></li>
          <li class="breadcrumb-item active" aria-current="page"> Edit Proyek </li>
        </ol>
      </nav>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <form action="{{route('proyekUpdate',['id'=>$proyek->id])}}" method="POST" enctype="multipart/form-data">
        @method('patch')
        @csrf
      <div class="card-header">
        <h4>Edit Data PT</h4>
      </div>
        <div class="card-body">
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama PT</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('namaPT') is-invalid @enderror" name="namaPT" value="{{$proyek->namaPT}}">
              @error('namaPT')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alamat</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('alamatPT') is-invalid @enderror" name="alamatPT" value="{{$proyek->alamatPT}}">
              @error('alamatPT')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Telepon</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('telpPT') is-invalid @enderror" name="telpPT" value="{{$proyek->telpPT}}">
              @error('telpPT')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
            <div class="col-sm-12 col-md-7">
              <input type="email" class="form-control @error('emailPT') is-invalid @enderror" name="emailPT" value="{{$proyek->emailPT}}">
              @error('emailPT')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Logo PT</label>
            <div class="col-sm-12 col-md-7">
              {{-- <img src="{{Storage::url($proyek->logoPT)}}" alt=""> --}}
              <input type="file" class="form-control @error('logoPT') is-invalid @enderror" name="logoPT" id="logoPT" value="{{old('logoPT')}}">
              <div class="text-primary">Ukuran logo disarankan 200x100px</div>
              <img src="{{Storage::url($proyek->logoPT)}}" id="img-tag" width="100%">
              @error('logoPT')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
              <script type="text/javascript">
                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        
                        reader.onload = function (e) {
                            $('#img-tag').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
                $("#logoPT").change(function(){
                    readURL(this);
                });
            </script>
            </div>
          </div>
        </div>
        <div class="card-header">
          <h4>Edit Data Proyek</h4>
        </div>
        <div class="card-body">
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Proyek</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{$proyek->nama}}">
              @error('nama')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Lokasi</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi" value="{{$proyek->lokasi}}">
              @error('lokasi')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Proyek Dimulai</label>
            <div class="col-sm-12 col-md-7">
              <input type="date" class="form-control @error('proyekStart') is-invalid @enderror" name="proyekStart" value="{{$proyek->proyekStart}}">
              @error('proyekStart')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
          <div class="col-sm-12 col-md-7">
            <button class="btn btn-primary" type="submit">Update</button>
          </div>
        </div>
      </div>
    </form>
    </div>
  </div>
</div>

@endsection