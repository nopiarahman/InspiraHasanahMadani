<table class="table table-sm table-striped table-hover mt-3">
  <thead>
    <tr>
      <th style="font-weight: bold; weight:20px; font-size:22pt; text-align:center" colspan="7">KAS BESAR</th>
    </tr>
    <tr>
      <th style="width: 20pt;text-align:center;font-style:italic" colspan="7">{{namaProyek()}}</th>
    </tr>
    <tr>
      <th style="width: 20pt;" colspan="7">Periode : {{Carbon\Carbon::parse($start)->isoFormat('DD MMMM Y')}} - {{Carbon\Carbon::parse($end)->isoFormat('DD MMMM Y')}}</th>
    </tr>
    <tr></tr>
    <tr>
      <th style="font-weight: bold; weight:20px" scope="col">Tanggal</th>
      <th style="font-weight: bold; weight:20px" scope="col">Kode Transaksi</th>
      <th style="font-weight: bold; weight:20px" scope="col">Uraian</th>
      <th style="font-weight: bold; weight:20px" scope="col">Kredit</th>
      <th style="font-weight: bold; weight:20px" scope="col">Debit</th>
      <th style="font-weight: bold; weight:20px" scope="col">Saldo</th>
      <th style="font-weight: bold; weight:20px" scope="col">Sumber</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="width: 20px" colspan="2"></td>
      <th style="font-weight: bold; weight:20px" class="text-primary " colspan="3" >Sisa Saldo Sebelumnya</th>
      <th style="font-weight: bold; weight:20px" class="text-primary">Rp.{{number_format(saldoBulanSebelumnya($start))}}</th>
    </tr>
    @foreach($cashFlow as $transaksi)
    <tr>
      <td style="width: 20px">{{formatTanggal($transaksi->tanggal)}}</td>
      <td style="width: 20px">{{$transaksi->akun->kodeAkun}}</td>
      <td style="width: 20px">{{$transaksi->uraian}}</td>
      <td style="width: 20px">
        @if($transaksi->kredit != null)
        Rp.{{number_format($transaksi->kredit)}}
        @endif
      </td>
      <td style="width: 20px">
        @if($transaksi->debet != null)
        Rp.{{number_format($transaksi->debet)}}
        @endif
      </td>
      <td style="width: 20px">Rp.{{number_format($transaksi->saldo)}}</td>
      <td style="width: 20px">{{$transaksi->sumber}}</td>
    </tr>
    @endforeach
  </tbody>
  <tfoot>
      <tr class="bg-light">
        <th style="font-weight: bold; weight:20px" colspan="3" class="text-right text-primary">Total</th>
        <th style="font-weight: bold; weight:20px" class="text-primary">Rp. {{number_format($cashFlow->sum('kredit'))}}</th>
        <th style="font-weight: bold; weight:20px" class="text-primary">Rp. {{number_format($cashFlow->sum('debet'))}}</th>
        <th style="font-weight: bold; weight:20px" colspan="3" class="text-primary">Rp. {{number_format(totalKasBesar($start,$end))}}</th>
      </tr>
  </tfoot>
</table>