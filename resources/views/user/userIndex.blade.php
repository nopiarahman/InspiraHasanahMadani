@extends('layouts.tema')
@section ('menuUser','active')
@section('content')
<div class="section-header">
  <div class="container">
    <div class="row">
      <div class="col">
        <h1>User</h1>
      </div>
    </div>
    <div class="row">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb  bg-white mb-n2">
          <li class="breadcrumb-item" aria-current="page"> User </li>
        </ol>
      </nav>
    </div>
  </div>
</div>

<div class="section-header">
    <a href="{{route('userTambah')}}" class="btn btn-primary">Tambah User Baru</a>
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
      <h4>Daftar User</h4>
    </div>
    <div class="card-body">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Proyek</th>
            <th scope="col">Jabatan</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($semuaUser as $user)
          <tr>
            <th scope="row">{{$loop->iteration}}</th>
            <td>{{$user->name}}</td>
            <td>{{$user->username}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->proyek->nama}}</td>
            <td>{{$user->role}}</td>
            <td>
              {{-- <a href="{{route('userEdit',['id'=>$user->id])}}" class="btn btn-white text-primary border-success"> <i class="fas fa-pen    "></i> Edit</a> --}}
              <button type="button" class="btn btn-sm btn-white text-primary border-success" 
              data-toggle="modal" 
              data-target="#modalEdit" 
              data-id="{{$user->id}}" 
              data-name="{{$user->name}}" 
              data-email="{{$user->email}}" 
              data-proyek="{{$user->proyek->id}}" 
              data-role="{{$user->role}}" 
              >
              <i class="fa fa-pen" aria-hidden="true" ></i> Edit</button>
              <button type="button" class="btn btn-sm btn-white text-danger border-danger" 
              data-toggle="modal" 
              data-target="#exampleModalCenter" 
              data-id="{{$user->id}}" 
              data-nama="{{$user->name}}">
              <i class="fa fa-trash" aria-hidden="true" ></i> Hapus</button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      
    </div>
  </div>
  {{-- edit --}}
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
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Lengkap</label>
              <div class="col-sm-12 col-md-7">
                <input type="hidden" name="user_id" value="" id="userId">
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" id="name">
                @error('name')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="" id="email">
                @error('email')
                  <div class="invalid-feedback">{{$message}}</div>
                @enderror
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jabatan</label>
              <div class="col-sm-12 col-md-7">
                <select class="form-control selectric" tabindex="-1" name="jabatan" id="jabatan">
                  <option value="admin">Super Admin</option>
                  <option value="adminWeb">Admin Website</option>
                  <option value="adminGudang">Admin Gudang</option>
                  <option value="marketing">Marketing</option>
                  <option value="gudang">Gudang</option>
            </select>
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Proyek</label>
              <div class="col-sm-12 col-md-7">
                <select class="form-control selectric" tabindex="-1" name="proyek" id="proyek">
                  @forelse($semuaProyek as $proyek)
                  <option value="{{$proyek->id}}">{{$proyek->nama}}</option>
                  @empty
                  <option value="">Belum ada proyek</option>
                  @endforelse
                </select>
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Password</label>
              <div class="col-sm-12 col-md-7">
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="sandi" value="">
                @error('password')
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
  <script type="text/javascript">
    $(document).ready(function () {
      $('#modalEdit').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var id = button.data('id') // Extract info from data-* attributes
      var name = button.data('name') 
      var email = button.data('email') 
      var role = button.data('role') 
      var proyek = button.data('proyek') 
      document.getElementById('formEdit').action='userEdit/'+id;
      $('#userId').val(id);
      $('#name').val(name);
      $('#email').val(email);
      $('#role').val(role);
      $('#proyek').val(proyek);
      })
    });
  </script>
  <script type="text/javascript">
    $(document).ready(function () {
      $('#exampleModalCenter').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var id = button.data('id') // Extract info from data-* attributes
      var nama = button.data('nama') 
      var modal = $(this)
      modal.find('.modal-text').text('Hapus User ' + nama+' ?')
      document.getElementById('formHapus').action='hapusUser/'+id;
      })
    });
    </script>
@endsection