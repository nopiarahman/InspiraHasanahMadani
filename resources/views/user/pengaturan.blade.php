@extends('layouts.tema')
@section('head')
<style>

  .profile-pic-div{
    height: 200px;
    width: 200px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    border-radius: 50%;
    overflow: hidden;
    border: 1px solid grey;
  }
  
  #photo{
    height: 100%;
    width: 100%;
  }
  
  #file{
    display: none;
  }
  
  #uploadBtn{
    height: 40px;
    width: 100%;
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    text-align: center;
    background: rgba(0, 0, 0, 0.7);
    color: wheat;
    line-height: 30px;
    font-family: sans-serif;
    font-size: 15px;
    cursor: pointer;
    display: none;
  }
</style>
@endsection
@section('content')

<div class="section-header">
  <div class="container">
    <div class="row">
      <div class="col">
        <h1>Pengaturan</h1>
      </div>
    </div>
  </div>
</div>
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
<div class="card">
  <div class="card-header">
    <h4>Foto</h4>
  </div>
  <div class="card-body">
    <div class="profil-widget">
      <div class="profile-widget-header row justify-content-center mb-5 ">
        <div class="profile-pic-div mb-5">
          <form action="{{route('gantiFoto',['id'=>$detail->id])}}" method="post" enctype="multipart/form-data" id="formFoto">
            @method('patch')
            @csrf
            @if($detail->poto != null)
            <img src="{{Storage::url($detail->poto)}}" id="photo" >
            @else
            <img src="../assets/img/avatar/avatar-1.png" id="photo">
            @endif
            <input type="file" id="file" name="foto" onchange="submit()">
            <label for="file" id="uploadBtn">Choose Photo</label>
          </div>
          {{-- <img alt="image" src="../assets/img/avatar/avatar-1.png" class=" rounded-circle profile-widget-picture" width="150px"> --}}
        </div>
      </form>
    </div>
  </div>
  <div class="row justify-content-center mt-5">
    <h4 class="mt-5">{{auth()->user()->name}}</h4>
  </div>
</div>
<div class="card">
  <div class="card-header">
    <h4>Username dan Password</h4>
  </div>
  <div class="card-body">
    <form action="{{route('rubahPassword',['id'=>$user->id])}}" method="POST" enctype="multipart/form-data">
      @method('patch')
        @csrf
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Username</label>
          <div class="col-sm-12 col-md-7">
            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{$user->username}}">
            @error('username')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Password Baru</label>
          <div class="col-sm-12 col-md-7">
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{old('password')}}">
            @error('password')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Ulangi Password</label>
          <div class="col-sm-12 col-md-7">
            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="{{old('password_confirmation')}}">
            @error('password_confirmation')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
          </div>
        </div>
        <div class="card-footer">
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
            <div class="col-sm-12 col-md-7">
              <button class="btn btn-primary ml-n2" type="submit">Simpan</button>
            </div>
          </div>
        </div>
    </form>
  </div>
</div>
<script text="text/javascript">
const imgDiv = document.querySelector('.profile-pic-div');
const img = document.querySelector('#photo');
const file = document.querySelector('#file');
const uploadBtn = document.querySelector('#uploadBtn');

//if user hover on img div 

imgDiv.addEventListener('mouseenter', function(){
    uploadBtn.style.display = "block";
});

//if we hover out from img div

imgDiv.addEventListener('mouseleave', function(){
    uploadBtn.style.display = "none";
});

//lets work for image showing functionality when we choose an image to upload

//when we choose a foto to upload

file.addEventListener('change', function(){
    //this refers to file
    const choosedFile = this.files[0];

    if (choosedFile) {

        const reader = new FileReader(); //FileReader is a predefined function of JS

        reader.addEventListener('load', function(){
            img.setAttribute('src', reader.result);
        });

        reader.readAsDataURL(choosedFile);
    }
});
function submit(){
          alert('test');
          document.forms["formFoto"].submit();
        }

</script>
@endsection