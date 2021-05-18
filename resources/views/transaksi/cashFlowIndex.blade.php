@extends('layouts.tema')
@section ('cashFlow','active')
@section ('menuTransaksi','active')
@section('content')
<div class="section-header sticky-top">
  <div class="container">
    <div class="row">
      <div class="col">
        <h1>Cash Flow</h1>
      </div>
    </div>
    <div class="row">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb  bg-white mb-n2">
          <li class="breadcrumb-item" aria-current="page"> Cash Flow </li>
        </ol>
      </nav>
    </div>
  </div>
</div>

<div class="section-header">

</div>

<div class="card">
  <div class="card-header">
    <h4>Daftar Cash Flow</h4>
  </div>
  <div class="card-body">
    <table class="table table-sm table-striped">
      <thead>
        <tr>
          <th scope="col">Tanggal</th>
          <th scope="col">Kode Transaksi</th>
          <th scope="col">Uraian</th>
          <th scope="col">Kredit</th>
          <th scope="col">Debit</th>
          <th scope="col">Saldo</th>
          <th scope="col">Sumber</th>
        </tr>
      </thead>
      <tbody>
        @foreach($cashFlow as $transaksi)
        <tr>
          <td>{{formatTanggal($transaksi->tanggal)}}</td>
          <td>{{$transaksi->akun->kodeAkun}}</td>
          <td>{{$transaksi->uraian}}</td>
          <td>
            @if($transaksi->kredit != null)
            Rp.{{number_format($transaksi->kredit)}}
            @endif
          </td>
          <td>
            @if($transaksi->debit != null)
            Rp.{{number_format($transaksi->debit)}}
            @endif
          </td>
          <td>Rp.{{number_format($transaksi->saldo)}}</td>
          <td>{{$transaksi->sumber}}</td>
          {{-- <td><a href="#" class="badge badge-primary">Detail</a></td> --}}
        </tr>
        @endforeach
      </tbody>
    </table>
    {{$cashFlow->links()}}
  </div>
</div>
@endsection