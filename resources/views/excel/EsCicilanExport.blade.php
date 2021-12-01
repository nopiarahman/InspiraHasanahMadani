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
          @if(cekDPLunasBulanan($cicilan,$start)==="lunas")
            <tr>
              <td>{{$n, $n++}}</td>
              <td>{{$cicilan->pelanggan->nama}} | {{$cicilan->kavling->blok}}</td>
              <td>{{$cicilan->pelanggan->nomorTelepon}}</td>
              @if ($cicilan->tenor ===0)
              @php
                  $nilai = $cicilan->sisaKewajiban
              @endphp
              @else
              @php
                  $nilai = $cicilan->sisaKewajiban/$cicilan->tenor
              @endphp
              @endif
              <td data-order="{{$nilai}}">Rp. {{number_format($nilai)}}</td>
              @php
                  $totalCicilan += $nilai;
              @endphp
                <td><a href="{{route('unitKavlingDetail',['id'=>$cicilan->id])}}"> 
                  @if (cekCicilanBulananTerbayar($cicilan,$start)!=null)
                  {{cekCicilanBulananTerbayar($cicilan,$start)->jumlah}}
                  @php
                      $totalTerbayar += cekCicilanBulananTerbayar($cicilan,$start)->jumlah;
                  @endphp
                  @elseif(cekCicilanSekaligus($cicilan,$start)!=null)
                  s/d {{formatBulanTahun(cekCicilanSekaligus($cicilan,$start)->tempo)}}
                  @else
                  <span class="text-danger">Belum bayar</span>
                  @endif
                  </a>
                </td>
                <td>
                  @if(cekCicilanBulananTerbayar($cicilan,$start))
                    {{formatTanggal(cekCicilanBulananTerbayar($cicilan,$start)->tanggal)}}
                  @endif
                </td>
                <td>
                  <i class="fa fa-times text-danger" aria-hidden="true"></i>
                </td>
            </tr>
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