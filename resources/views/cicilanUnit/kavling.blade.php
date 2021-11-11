@extends('layouts.tema')
@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section ('menuCicilanUnit','active')
@section('content')
<div class="section-header">
  <div class="container">
    <div class="row">
      <div class="col">
        <h1>Cicilan Unit </h1>
      </div>
    </div>
    <div class="row">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb  bg-white mb-n2">
          <li class="breadcrumb-item" aria-current="page"> Cicilan Unit  </li>
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

  <div class="card">
    <div class="card-header">
      <h4>Daftar Cicilan Unit</h4>
    </div>
    <div class="card-body">
      <table class="table table-hover table-responsive-sm" id="table">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama</th>
            <th scope="col">Blok</th>
            <th scope="col">Jenis</th>
            <th scope="col">Sisa Kewajiban</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @php
                $n=0;
            @endphp
          @foreach($semuaCicilanUnit as $cicilanUnit)
          @if($cicilanUnit->pelanggan !=null && $cicilanUnit->pelanggan->kavling !=null)
          {{-- {{updateCicilanPelanggan($cicilanUnit)}} --}}
          @php
                  $n++
              @endphp
          <tr>
            <th scope="row">{{$n}}</th>
            <td>
              <a href="{{route('pelangganDetail',['id'=>$cicilanUnit->pelanggan->id])}}" class="text-primary">
              {{$cicilanUnit->pelanggan->nama}}
              {{-- {{$cicilanUnit->pelanggan->id}} --}}
              </a>
            </td>
            @if($cicilanUnit->pelanggan->kavling==null)
            <td>Batal Akad</td>
            @else
            <td>{{unitPelanggan($cicilanUnit->kavling_id)->blok}}</td>
            @endif
            <td>{{jenisKepemilikan($cicilanUnit->pelanggan_id)}}</td>
            <td>
              @if($cicilanUnit->sisaCicilan != null ||$cicilanUnit->sisaCicilan <=0)
              Rp.{{number_format($cicilanUnit->sisaCicilan)}}
              @else
              Rp.{{number_format($cicilanUnit->sisaKewajiban)}}
              @endif
            </td>
            <td>
              @if($cicilanUnit->dp <= cekTotalDp($cicilanUnit->id))
              <a href="{{route('unitKavlingDetail',['id'=>$cicilanUnit->id])}}" class="btn btn-white text-primary border-success btn-sm">Pembayaran</a>
              @else
              <a href="#" class="badge badge-secondary">DP Belum Lunas</a>
              @endif
              @if($cicilanUnit->sisaKewajiban==0)
              <span class="badge badge-info"><i class="fas fa-check"></i> Lunas</span>
              @endif
            </td>
          </tr>
          @endif
          @endforeach

        </tbody>

      </table>
      {{-- {{$semuaCicilanUnit->links()}} --}}
    </div>
  </div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script>
  // $(document).ready(function() {
    $('#table').DataTable({
      "pageLength":     25,
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
  // });
</script>
@endsection