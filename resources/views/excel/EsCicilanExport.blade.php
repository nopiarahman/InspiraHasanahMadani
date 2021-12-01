<table class="table table-sm table-striped table-hover mt-3">
  <thead>
    <tr>
      <th style="font-weight: bold; weight:20px; font-size:22pt; text-align:center" colspan="7">Estimasi Cicilan</th>
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
      <th style="font-weight: bold; weight:20px" scope="col">Nilai Cicilan</th>
      <th style="font-weight: bold; weight:20px" scope="col">Terbayar</th>
      <th style="font-weight: bold; weight:20px" scope="col">Tanggal Pembayaran</th>
    </tr>
  </thead>
  <tbody>
    @php
              $totalCicilan = 0;
              $totalTerbayar=0;
              $n=1;
          @endphp
          @foreach($cicilanAktif as $cicilan)
          @if ($cicilan)
            @if (cekPembayaranCicilan($cicilan->id)==null && $cicilan->pembelian->sisaKewajiban <= 0)
            @else
            <tr>
              <td>{{$n}}</td>
              @php
                  $n++;
              @endphp
              <td> {{$cicilan->pelanggan->nama}} | {{$cicilan->pelanggan->kavling->blok}}</td>
              <td>{{$cicilan->pelanggan->nomorTelepon}}</td>
              @if ($cicilan->pembelian->sisaKewajiban/$cicilan->pembelian->tenor >= $cicilan->sisaKewajiban)
              @php
                  $nilai = $cicilan->sisaKewajiban
              @endphp
              @else
              @php
                  $nilai = $cicilan->pembelian->sisaKewajiban/$cicilan->pembelian->tenor
              @endphp
              @endif
              <td data-order="{{$nilai}}">{{$nilai}}</td>
              @php
                  $totalCicilan += $nilai;
              @endphp
              @if (cekPembayaranCicilan($cicilan->id)==null)
                  <td> <a href="{{route('unitKavlingDetail',['id'=>$cicilan->pembelian->id])}}"> <span class="text-danger"> Belum Dibayar</span></a></td>
              @else
                  <td data-order="{{cekPembayaranCicilan($cicilan->id)}}"><a href="{{route('unitKavlingDetail',['id'=>$cicilan->pembelian->id])}}"> 
                    <span class="text-primary">{{cekPembayaranCicilan($cicilan->id)}}</span> </a></td>
              @endif
              @php
                  $totalTerbayar +=cekPembayaranCicilan($cicilan->id);
              @endphp
                @if(cekPembayaranEstimasi($cicilan->id)!=null)
                <td data-order="{{cekPembayaranEstimasi($cicilan->id)->tanggal}}">
                  {{formatTanggal(cekPembayaranEstimasi($cicilan->id)->tanggal)}}
                </td>
                @else
                <td></td>
              @endif
            </tr>
            @endif
          @endif
          @endforeach
  </tbody>
  <tfoot>
      <tr class="bg-light">
        <th style="font-weight: bold; weight:20px" colspan="3" class="text-right text-primary">Total Estimasi Pendapatan : </th>
        <th style="font-weight: bold; weight:20px" class="text-primary">{{$totalCicilan}}</th>
        <th style="font-weight: bold; weight:20px" class="text-right text-primary">Total Realisasi : </th>
        <th style="font-weight: bold; weight:20px" class="text-primary">{{$totalTerbayar}}</th>
      </tr>
  </tfoot>
</table>