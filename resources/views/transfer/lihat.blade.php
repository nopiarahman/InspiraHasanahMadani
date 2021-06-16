@extends('layouts.tema')
@if(auth()->user()->role=="admin")
  @section ('menuCicilanUnit','active')
@elseif(auth()->user()->role=="pelanggan")
  @section ('menuUnitPelanggan','active')
@endif
@section('content')
<div class="section-header sticky-top">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1> Cicilan Unit</h1>
        </div>
      </div>
      <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb  bg-white mb-n2">
            <li class="breadcrumb-item"> <a href="{{route('unitPelanggan')}}"> Cicilan Unit </a></li>
            <li class="breadcrumb-item"> <a href="{{route('cekTransferUnitPelanggan')}}"> Transfer </a></li>
            <li class="breadcrumb-item" aria-current="page"> Lihat </li>
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

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4>Pembayaran Unit</h4>
      </div>
      <div class="card-body">
      <form action="{{route('cicilanKavlingSimpan')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal Transfer</label>
          <div class="col-sm-12 col-md-7">
            <input type="hidden" class="form-control " name="pembelian_id" value="{{$id->pembelian_id}}" >
            <input type="date" readonly class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="{{$id->tanggal}}" >
            @error('tanggal')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
          </div>
        </div>
        
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nominal Pembayaran</label>
          <div class="input-group col-sm-12 col-md-7">
            <div class="input-group-prepend">
              <div class="input-group-text">
                Rp
              </div>
            </div>
            <input type="text" readonly class="jumlah form-control @error('jumlah') is-invalid @enderror" name="jumlah" value="{{$id->jumlah}} " id="jumlah">
            @error('jumlah')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Rekening Tujuan</label>
          <div class="col-sm-12 col-md-7">
            <select class="form-control selectric" tabindex="-1" name="rekening_id" >
              @forelse ($rekening as $item)
              <option @if($id->rekening_id == $item->id) selected @endif value="{{$item->id}}">{{$item->namaBank}} {{$item->noRekening}} - a/n {{$item->atasNama}}</option>
              @empty
              <option value="">Belum Ada Rekening</option>                  
              @endforelse
            </select>
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Pemilik Rekening</label>
          <div class="col-sm-12 col-md-7">
            <input readonly type="text" class="form-control @error('namaPemilik') is-invalid @enderror" name="namaPemilik" value="{{$id->namaPemilik}}">
            @error('namaPemilik')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
          </div>
        </div>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bukti Transfer</label>
          <div class="input-group col-sm-12 col-md-7">
            {{-- <img src="" id="img-tag" width="500px"> --}}
            <img src="{{Storage::url($id->bukti)}}" alt="" id="img-tag" width="500px">
            {{-- <div class="custom-file"> --}}
              {{-- <input type="file" name="bukti" id="bukti"> --}}
              {{-- <label class="custom-file-label" for="customFile"></label> --}}
            {{-- </div> --}}
            @error('bukti')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
            {{-- <span>*file .jpg/.png/ .pdf/ .jpeg</span> --}}
          </div>
        </div>
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
          $("#bukti").change(function(){
              readURL(this);
          });
      </script>
        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
          <div class="col-sm-12 col-md-7">
            <button type="button" class="btn btn-primary " 
                  data-toggle="modal" 
                  data-target="#modalTerima">
                  <i class="fa fa-check" aria-hidden="true"></i> Terima Pembayaran</button>
            <button type="button" class="btn btn-danger " 
                  data-toggle="modal" 
                  data-target="#modalTolak">
                  <i class="fa fa-times-circle" aria-hidden="true"></i>  Tolak Pembayaran</button>
          </div>
        </div>
      <!-- Modal Terima-->
      <div class="modal fade modalTerima" id="modalTerima" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Terima Transaksi</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Sebelum menerima pastikan transaksi telah dipastikan benar, apakah anda yakin?
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Ya, Terima Transaksi</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              </div>
          </div>
        </div>
      </div>
    </form>
      {{-- modal tolak --}}
      <div class="modal fade modalTolak  ml-5" id="modalTolak" tabindex="-1" role="dialog" aria-labelledby="modalEditTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Tolak Pembayaran</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{route('tolakTransfer',['id'=>$id->id])}}" method="POST" enctype="multipart/form-data">
                @method('patch')
                @csrf
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Keterangan</label>
                  <div class="col-sm-12 col-md-7">
                    <input type="text" class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" value="" id="namaEdit">
                    @error('keterangan')
                      <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                  </div>
                </div>
                <div class="form-group row mb-4">
                  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                  <div class="col-sm-12 col-md-7">
                    <button class="btn btn-danger" type="submit"> <i class="fa fa-times-circle" aria-hidden="true"></i> Tolak!</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                  </div>
                </div>
              </form>
              </div>
          </div>
        </div>
      </div>

      </div>
      <div class="card-footer">
        <p class="text-primary">Catatan: Pembayaran melalui cash tidak perlu melakukan isi data</p>
      </div>
    </div>
  </div>
</div>
    <!-- Modal Hapus-->
    <div class="modal fade exampleModalCenter" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Hapus Transaksi</h5>
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
        var id = button.data('id')
        var modal = $(this)
        modal.find('.modal-text').text('Yakin ingin menghapus transaksi ini ?')
        document.getElementById('formHapus').action='/hapusCicilan/'+id;
        })
      });
    </script>
<script src="{{ mix("js/cleave.min.js") }}"></script>
<script>
  var cleave = new Cleave('.jumlah', {
      numeral: true,
      numeralThousandsGroupStyle: 'thousand'
  });
 </script>
@endsection