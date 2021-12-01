<table class="table table-sm table-striped table-hover mt-3">
  <thead>
    <tr>
      <th style="font-weight: bold; weight:20px; font-size:22pt; text-align:center" colspan="7">Estimasi DP</th>
    </tr>
    <tr>
      <th style="width: 20pt;text-align:center;font-style:italic" colspan="7">{{namaProyek()}}</th>
    </tr>
    <tr>
      <th style="width: 20pt;" colspan="7">Periode : {{Carbon\Carbon::parse($start)->isoFormat('DD MMMM Y')}} - {{Carbon\Carbon::parse($end)->isoFormat('DD MMMM Y')}}</th>
    </tr>
    <tr></tr>
    <tr>
      <th style="font-weight: bold; weight:20px" scope="col">No</th>
      <th style="font-weight: bold; weight:20px" scope="col">Nama</th>
      <th style="font-weight: bold; weight:20px" scope="col">No Telp</th>
      <th style="font-weight: bold; weight:20px" scope="col">Nilai DP</th>
      <th style="font-weight: bold; weight:20px" scope="col">Terbayar</th>
      <th style="font-weight: bold; weight:20px" scope="col">Tanggal Pembayaran</th>
      <th style="font-weight: bold; weight:20px" scope="col">Keterangan</th>
    </tr>
  </thead>
  <tbody>
    @php
    $n=1;
        $totalDP = 0;
        $totalDPTerbayar=0;
    @endphp
    @foreach($dpAktif as $dp)
      @if ($dp) 
        @if (cekPembayaranDP($dp->id,$start)==null && $dp->pembelian->sisaDp <= 0)
        @else
        <tr>
          <td>{{$n}}</td>
          @php
              $n++;
          @endphp
          <td>{{$dp->pelanggan->nama}} | {{$dp->pelanggan->kavling->blok}}</td>
          <td>{{$dp->pelanggan->nomorTelepon}} </td>
          @if ($dp->pembelian->dp/$dp->pembelian->tenorDP >= $dp->sisaDp)
              @php
                  $nilai = $dp->sisaDp
              @endphp
          @else
          @php
              $nilai = $dp->pembelian->dp/$dp->pembelian->tenorDP
          @endphp
          @endif
          <td data-order="{{$nilai}}">{{$nilai}}</td>
          @php
              $totalDP += $nilai;
          @endphp
          @if (cekPembayaranDP($dp->id,$start)==null)
              <td> <a href="{{route('DPKavlingTambah',['id'=>$dp->pembelian->id])}}"> 
                <span> Belum Dibayar</span></a></td>
          @else
              <td data-order="{{cekPembayaranDP($dp->id,$start)}}">  <a href="{{route('DPKavlingTambah',['id'=>$dp->pembelian->id])}}">
                <span>{{cekPembayaranDP($dp->id,$start)}}</span> </a></td>
          @endif
          @php
              $totalDPTerbayar +=cekPembayaranDP($dp->id,$start);
          @endphp
            @if(cekDPEstimasi($dp->id)!=null)
            <td>
              {{formatTanggal(cekDPEstimasi($dp->id)->tanggal)}}
            </td>
            @else
            <td></td>
            @endif
          @if ($dp->pembelian->sisaDp <= 0)
          <td> <span>DP LUNAS</span> </td>
          @else
          <td>Sisa DP: Rp. {{number_format($dp->pembelian->sisaDp)}}</td>
          @endif
        </tr>
        @endif
      @endif
    @endforeach
  </tbody>
  <tfoot>
      <tr class="bg-light">
        <th style="font-weight: bold; weight:20px" colspan="3" class="text-right text-primary">Total Estimasi Pendapatan : </th>
        <th style="font-weight: bold; weight:20px" class="text-primary">{{$totalDP}}</th>
        <th style="font-weight: bold; weight:20px" class="text-right text-primary">Total Realisasi : </th>
        <th style="font-weight: bold; weight:20px" class="text-primary">{{$totalDPTerbayar}}</th>
      </tr>
  </tfoot>
</table>