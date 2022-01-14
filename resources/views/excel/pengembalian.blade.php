<table class="table table-sm table-striped table-hover mt-3">
  <thead>
    <tr>
      <th style="font-weight: bold; weight:20px; font-size:22pt; text-align:center" colspan="7">Pengembalian Dana Batal Akad</th>
    </tr>
    <tr>
      <th style="width: 20pt;text-align:center;font-style:italic" colspan="7">{{$id->nama}}</th>
    </tr>
    <tr>
      <th style="width: 20pt;text-align:center;font-style:italic" colspan="7">{{namaProyek()}}</th>
    </tr>
    <tr>
      <th style="width: 30%">Nama Pelanggan </th>
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
      <th>Total Pengembalian Dana</th>
      <td>: Rp. {{number_format(cekTotalDp($id->pembelian->id)+cicilanTerbayarTotal($id->pembelian->id)-$id->pembelian->pengembalian)}}</td>
    </tr>
    <td></td>
    <tr>
      <th style="font-weight: bold; weight:20px;text-align:right" scope="col" >No</th>
      <th style="font-weight: bold; weight:20px" scope="col">Tanggal</th>
      <th style="font-weight: bold; weight:20px" scope="col">Jumlah</th>
      <th style="font-weight: bold; weight:20px" scope="col">Sisa Pengembalian</th>
    </tr>
  </thead>
  <tbody>
    @foreach($pengembalian as $p)
    <tr>
      <td>{{$loop->iteration}}</td>
      <td>{{formatTanggal($p->tanggal)}}</td>
      <td>{{$p->jumlah}}</td>
      <td>{{$p->sisaPengembalian}}</td>
    @endforeach
  </tbody>
  <tfoot>
    <tr>
      <th colspan="2" class="text-right text-primary">Total Transaksi</th>
      <th class="text-primary">{{$pengembalian->sum('jumlah')}}</th>
    </tr>
</table>