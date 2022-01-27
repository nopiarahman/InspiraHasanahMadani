
@extends('layouts.tema')
@section('head')
<style>

  .profile-pic-div{
    height: 500px;
    width: 300px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
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
<div class="card " style="height: 700px">
  <div class="card-header">
    <h4>Banner</h4>
    <span>Rekomendasi Ukuran Banner 300x500px</span>
  </div>
  <div class="card-body">
    <div class="profil-widget">
      <div class="profile-widget-header row justify-content-center mb-5 ">
        <div class="profile-pic-div mb-5">
          <form action="{{route('gantiBanner',['id'=>$detail->id])}}" method="post" enctype="multipart/form-data" id="formFoto">
            @method('patch')
            @csrf
            @if($detail->path  != null)
            <img src="{{Storage::url($detail->path)}}" id="photo" >
            @else
            <img src="{{asset('/frontPage/img/services/300x460.jpg')}}" id="photo">
            @endif

            <input type="file" id="file" name="foto" onchange="submit()">
            <label for="file" id="uploadBtn">Choose Photo</label>
            {{-- <img alt="image" src="../assets/img/avatar/avatar-1.png" class=" rounded-circle profile-widget-picture" width="150px"> --}}
          </form>
          </div>
        </div>
      </div>
    </div>
    <div class="justify-content-center">
      <div class="container mt-5 ">
        <form action="{{route('linkBanner',['id'=>$detail->id])}}" method="post" enctype="multipart/form-data" id="formFoto">
          @method('patch')
          @csrf
        <div class="form-group row mb-4">
          <label class="col-form-label col-2 text-right">Link</label>
          <div class="col-sm-12 col-md-7">
            <input type="text" class="form-control @error('link') is-invalid @enderror" name="link" value="{{$detail->link}}">
            @error('link')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
          </div>
          <button class="btn btn-primary col-2" type="submit">Simpan</button>
          </form>
        </div>
      </div>
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