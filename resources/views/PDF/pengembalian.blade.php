<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  {{-- <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
  <link rel="stylesheet" href="{{ mix("css/app.css") }}"> --}}
  <title>PENGEMBALIAN DANA BATAL AKAD</title>
  <style type="text/css">
  .styled-table {
      border-collapse: collapse;
      margin: 25px 0;
      font-size: 0.9em;
      font-family: sans-serif;
      width: 100%;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
  }
  .styled-table th {
    background-color: #009879;
    color: #ffffff;
    text-align: left;
  }
  .styled-table th,
  .styled-table td {
      padding: 12px 15px;
  }.styled-table tbody tr {
      border-bottom: 1px solid #dddddd;
  }

  .styled-table tbody tr:nth-of-type(even) {
      background-color: #f3f3f3;
  }

  .styled-table tbody tr:last-of-type {
      border-bottom: 2px solid #009879;
  }.styled-table tbody tr.active-row {
      font-weight: bold;
      color: #009879;
  }
  </style>
</head>
<body>
          <h3 style="text-align: center">Pengembalian Dana {{$id->nama}}</h3>
     
        <h4>1. Informasi Pengembalian Dana</h4>
        <table class="styled-table">
          <tr>
            <th>Nama Pelanggan </th>
            <td>: {{$id->nama}}</td>
          </tr>
          <tr>
            <th>Unit</th>
            <td>: {{$id->pembelian->kavling->blok}}</td>
          </tr> 
          <tr>
            <th>Total Pembayaran DP</th>
            <td>: Rp. {{number_format(cekTotalDp($id->pembelian->id))}}</td>
          </tr>
          <tr>
            <th>Total Pembayaran Unit</th>
            <td>: Rp. {{number_format(cicilanTerbayarTotal($id->pembelian->id))}}</td>
          </tr>
          <tr>
            <th>Potongan Biaya</th>
            <td>: Rp. {{number_format($id->pembelian->pengembalian)}} 
              @if(auth()->user()->role=="admin" || auth()->user()->role=="projectmanager" )    
              <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tanggalAkad"> 
                <i class="fas fa-pen    "></i> Ganti Nilai Potongan
              </button>
              @endif
            </td>
          </tr>
          <tr>
            <th>Total Pengembalian Dana</th>
            <td>: Rp. {{number_format(cekTotalDp($id->pembelian->id)+cicilanTerbayarTotal($id->pembelian->id)-$id->pembelian->pengembalian)}}</td>
          </tr>
        </table>
        </div>
      {{-- </div> --}}
        <h4>2. Daftar Pengembalian Dana</h4>
       
        <table class="styled-table">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Tanggal</th>
              <th scope="col">Jumlah</th>
              <th scope="col">Sisa Pengembalian</th>
              @if(auth()->user()->role=="admin"||auth()->user()->role=="projectmanager" )
              <th scope="col">Aksi</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @foreach($pengembalian as $p)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>{{formatTanggal($p->tanggal)}}</td>
              <td>Rp. {{number_format($p->jumlah)}}</td>
              <td>Rp. {{number_format($p->sisaPengembalian)}}</td>
              @if(auth()->user()->role=="admin"||auth()->user()->role=="projectmanager" )
              <td>
                <button type="button" class="btn btn-sm btn-white text-danger border-danger" 
                data-toggle="modal" 
                data-target="#hapusTransaksi" 
                data-id="{{$p->id}}">
                <i class="fa fa-trash" aria-hidden="true" ></i> Hapus</button>
              </td>
              @endif
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th colspan="2" class="text-right text-primary">Total Transaksi</th>
              <th colspan="3" class="text-primary">Rp. {{number_format($pengembalian->sum('jumlah'))}}</th>
            </tr>
          </tfoot>
        </table>
{{-- @endsection --}}
</body>
</html>
