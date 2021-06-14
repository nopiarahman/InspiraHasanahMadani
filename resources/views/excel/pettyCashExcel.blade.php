<table class="table table-sm table-hover table-striped mt-3">
  <thead>
    <tr>
      <th style="width: 20pt; font-weight:bold;font-size:22pt;text-align:center;" colspan="7">PETTY CASH</th>
    </tr>
    <tr>
      <th style="width: 20pt;text-align:center;font-style:italic" colspan="7">{{namaProyek()}}</th>
    </tr>
    <tr>
      <th style="width: 20pt;" colspan="7">Periode : {{Carbon\Carbon::parse($start)->isoFormat('DD MMMM Y')}} - {{Carbon\Carbon::parse($end)->isoFormat('DD MMMM Y')}}</th>
    </tr>
    <tr></tr>
    <tr>
      <th style="width: 20pt; font-weight:bold;" scope="col">No</th>
      <th style="width: 20pt; font-weight:bold;" scope="col">Tanggal</th>
      <th style="width: 20pt; font-weight:bold;" scope="col">Uraian</th>
      <th style="width: 20pt; font-weight:bold;" scope="col">Kredit</th>
      <th style="width: 20pt; font-weight:bold;" scope="col">Debit</th>
      <th style="width: 20pt; font-weight:bold;" scope="col">Saldo</th>
      <th style="width: 20pt; font-weight:bold;" scope="col">Sumber</th>
    </tr>
  </thead>
  <tbody>
      <tr>
        <td style="width: 20pt" colspan="2"></td>
        <th style="width: 20pt; font-weight:bold;text-align:right" class="text-primary " colspan="3" >Sisa Saldo Sebelumnya</th>
        <th style="width: 20pt; font-weight:bold;" class="text-primary">Rp.{{number_format(saldoPettyCashBulanSebelumnya($start))}}</th>
      </tr>
      @foreach($pettyCash as $kas)
      <tr>
        <td style="width: 20pt">{{$loop->iteration}}</td>
        <td style="width: 20pt">{{$kas->tanggal}}</td>
        <td style="width: 20pt">{{$kas->uraian}}</td>
        <td style="width: 20pt">
          @if($kas->kredit != null)
          Rp.{{number_format($kas->kredit)}}
          @endif
        </td>
        <td style="width: 20pt">
          @if($kas->debet != null)
          Rp.{{number_format($kas->debet)}}
          @endif
        </td>
        <td style="width: 20pt">Rp. {{number_format($kas->saldo)}}</td>
        <td style="width: 20pt">{{$kas->sumber}}</td>
      </tr>
      @endforeach
  </tbody>
  <tfoot>
    <tr class="bg-light">
      <th style="width: 20pt; font-weight:bold;text-align:right" colspan="3" class="text-right text-primary">Total</th>
      <th style="width: 20pt; font-weight:bold;" class="text-primary">Rp. {{number_format($pettyCash->sum('kredit'))}}</th>
      <th style="width: 20pt; font-weight:bold;" class="text-primary">Rp. {{number_format($pettyCash->sum('debet'))}}</th>
      <th style="width: 20pt; font-weight:bold;" colspan="2" class="text-primary">Rp. {{number_format(totalPettyCash($start,$end))}}</th>
      <td style="width: 20pt"></td>
    </tr>
  </tfoot>
</table>