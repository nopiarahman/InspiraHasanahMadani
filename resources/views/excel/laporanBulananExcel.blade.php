<table>
  <thead>
    <tr>
      <th style="width: 20pt; font-weight:bold;font-size:22pt;text-align:center;" colspan="4">Laporan Bulanan</th>
    </tr>
    <tr>
      <th style="width: 20pt;text-align:center;font-style:italic" colspan="4">{{namaProyek()}}</th>
    </tr>
    <tr>
      <th style="width: 20pt;" colspan="4">Periode : {{Carbon\Carbon::parse($start)->isoFormat('DD MMMM Y')}} - {{Carbon\Carbon::parse($end)->isoFormat('DD MMMM Y')}}</th>
    </tr>
    <tr></tr>
    <tr>
      <th style="width: 20pt;font-weight:bold;" scope="col" colspan="4" >Pendapatan</th>
    </tr>
  </thead>
  <tbody>
    @foreach($pendapatan as $pd)
    <tr>
      <td>{{$loop->iteration}}</td>
      <td colspan="2">{{$pd->uraian}}</td>
      <td>{{$pd->kredit}}</td>
    </tr>
    @endforeach
  {{-- </tbody> --}}

    <tr >
      <th style="width: 20pt;font-weight:bold;" colspan="3">Pendapatan Bulan {{\Carbon\carbon::parse($start)->isoFormat('MMMM')}}</th>
      <th style="width: 20pt;font-weight:bold;" >{{$pendapatan->sum('kredit')}}</th>
    </tr>
    <tr>
      <th style="width: 20pt;font-weight:bold;" colspan="3"  >Sisa Saldo Bulan {{\Carbon\carbon::parse($start)->subMonths(1)->isoFormat('MMMM')}}</th>
      <th style="width: 20pt;font-weight:bold;">{{saldoBulanSebelumnya($start)}}</th>
    </tr>
    <tr>
      <th style="width: 20pt;font-weight:bold;" colspan="3">Total Pendapatan</th>
      <th style="width: 20pt;font-weight:bold;" >{{saldoBulanSebelumnya($start)+$pendapatan->sum('kredit')}}</th>
    </tr>
    @php
    $a=[];
    $b=[];
    $c=[];
    $totalIsi=[];
    $perKategori = $kategoriAkun;
    @endphp
    @foreach($perKategori as $judul=>$kategoriAkun)
    @php
      $a[$judul]=0;
      $c[$judul]=0;
      $totalIsi[$judul]=0;
    @endphp
    <tr>
      <th style="width: 20pt;font-weight:bold;" colspan="4">{{$loop->iteration}}. {{$judul}}</th>
    </tr>
      @foreach($kategoriAkun as $kategori)
      <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$kategori->kodeAkun}}</td>
        <td>{{$kategori->namaAkun}}</td>
        <td>{{transaksiAkun($kategori->id,$start,$end)}}</td>
      </tr>
      @php
          $totalIsi[$judul]+=transaksiAkun($kategori->id,$start,$end);
      @endphp
      @endforeach
      @php
      $a[$judul]=$totalIsi[$judul]
      @endphp
      @php
          $c[$judul]=$a[$judul]-$c[$judul];
      @endphp
      <tr>
        <th style="width: 20pt;font-weight:bold;" colspan="3">Sub Total {{$judul}}</th>
        <th style="width: 20pt;font-weight:bold;">{{$a[$judul]}}</th>
      </tr>
    @endforeach
  </tbody>
  <tfoot>
    <tr>
      <th style="width: 20pt;font-weight:bold;" colspan="3">Total Biaya Operasional Bulanan</th>
        <th style="width: 20pt;font-weight:bold;" >{{array_sum($c)}}</th>
    </tr>
    <tr>
      <th style="width: 20pt;font-weight:bold;" colspan="3">Total Laba/Rugi Berjalan</th>
        <th style="width: 20pt;font-weight:bold;" >{{$pendapatan->sum('kredit')+saldoBulanSebelumnya($start)-array_sum($c)}}</th>
    </tr>
  </tfoot>
</table>