@extends('layouts.tema')
@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section ('menuCicilanDP','active')
@section('content')
<div class="section-header">
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>Cicilan Dp</h1>
        </div>
      </div>
      <div class="row">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb  bg-white mb-n2">
            <li class="breadcrumb-item" aria-current="page"> Cicilan Dp </li>
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
        <h4>Daftar Cicilan DP</h4>
      </div>
      <div class="card-body">
        <table class="table table-hover table-responsive-sm" id="table">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Nama</th>
              <th scope="col">Blok</th>
              <th scope="col">Jenis</th>
              <th scope="col">Sisa DP</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @php
                $n=0;
            @endphp
            @foreach($semuaCicilanDp as $cicilanDp)
            @if($cicilanDp->pelanggan !=null && $cicilanDp->pelanggan->kavling !=null)
            {{-- {{updateDPPelanggan($cicilanDp)}} --}}
            <tr>
              @php
                  $n++
              @endphp
              <th scope="row">{{$n}}</th>
              <td>
                
                <a href="{{route('pelangganDetail',['id'=>$cicilanDp->pelanggan->id])}}" class="text-primary">
                {{$cicilanDp->pelanggan->nama}}
                </a>
              </td>
              @if($cicilanDp->pelanggan->kavling==null)
              <td>Batal Akad</td>
              @else
              <td>{{$cicilanDp->kavling->blok}}</td>
              @endif
              <td>{{jenisKepemilikan($cicilanDp->pelanggan_id)}}</td>
              <td data-order="{{$cicilanDp->dp-cekTotalDp($cicilanDp->id)}}" >Rp.{{number_format($cicilanDp->dp-cekTotalDp($cicilanDp->id))}}</td>
              <td><a href="{{route('DPKavlingTambah',['id'=>$cicilanDp->id])}}" class="btn btn-white btn-sm text-primary border-success">Pembayaran</a>
                @if($cicilanDp->dp<=cekTotalDp($cicilanDp->id))
                <span class="badge badge-white text-info"><i class="fas fa-check"></i> Lunas</span>
                @endif
              </td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
        {{-- {{$semuaCicilanDp->links()}} --}}
      </div>
    </div>
@endsection
@section('script')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script type="text/javascript" >
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
</script>
@endsection