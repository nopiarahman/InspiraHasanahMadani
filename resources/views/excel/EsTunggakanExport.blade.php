<table class="table table-sm table-striped table-hover mt-3">
  <thead>
    <tr>
      <th style="font-weight: bold; weight:20px; font-size:22pt; text-align:center" colspan="7">Tunggakan</th>
    </tr>
    <tr>
      <th style="width: 20pt;text-align:center;font-style:italic" colspan="7">{{namaProyek()}}</th>
    </tr>
    {{-- <tr>
      <th style="width: 20pt;" colspan="7">Periode : {{Carbon\Carbon::parse($start)->isoFormat('DD MMMM Y')}} - {{Carbon\Carbon::parse($end)->isoFormat('DD MMMM Y')}}</th>
    </tr> --}}
    <tr></tr>
    <tr>
      <th style="font-weight: bold; weight:20px" scope="col">No</th>
      <th style="font-weight: bold; weight:20px" scope="col">Nama</th>
      <th style="font-weight: bold; weight:20px" scope="col">Blok</th>
      <th style="font-weight: bold; weight:20px" scope="col">Jenis</th>
      <th style="font-weight: bold; weight:20px" scope="col">No Telp</th>
      <th style="font-weight: bold; weight:20px" scope="col">Jatuh Tempo</th>
      <th scope="col">Nominal Tunggakan - {{Carbon\Carbon::parse($start)->isoFormat('MMMM')}}</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th colspan="7" style="font-weight: bold; text-align: center">TUNGGAKAN DP</th>
    </tr>
    @php
        $n=1;
    @endphp
    @foreach ($DPtertunggak as $tunggakan)
    @if($tunggakan && bulanDpTunggakanBerjalan($tunggakan)>0)
      <tr>
        <td>{{$n,$n++}}</td>
        <td>{{$tunggakan->pelanggan->nama}}</td>
        <td>{{$tunggakan->pelanggan->kavling->blok}}</td>
        <td>{{jenisKepemilikan($tunggakan->pelanggan->id)}}</td>
        <td>{{$tunggakan->pelanggan->nomorTelepon}}</td>
        <td data-order="{{$tunggakan->tempo}}"><a class="text-danger" href="{{route('DPKavlingTambah',['id'=>$tunggakan->pembelian_id])}}">
          1-10 {{Carbon\Carbon::parse($tunggakan->tempo)->isoFormat('MMMM YYYY')}}
          </a>
        </td>
        <td data-order="{{bulanDpTunggakanBerjalan($tunggakan)}}">Rp. {{number_format(bulanDpTunggakanBerjalan($tunggakan))}}</td>
      </tr>
    @endif
  @endforeach
  <tr>
    <th colspan="7" style="font-weight: bold; text-align: center">TUNGGAKAN CICILAN</th>
  </tr>
    @php
      $n=1;
    @endphp
    @forelse ($cicilanTertunggak as $tunggakan)
    @if($tunggakan)
    <tr>
      <td>{{$n,$n++}}</td>
      <td>{{$tunggakan->pelanggan->nama}}</td>
      <td>{{$tunggakan->pelanggan->kavling->blok}}</td>
      <td>{{jenisKepemilikan($tunggakan->pelanggan->id)}}</td>
      <td>{{$tunggakan->pelanggan->nomorTelepon}}</td>
      <td data-order="{{$tunggakan->tempo}}">
        <a class="text-danger" href="{{route('unitKavlingDetail',['id'=>$tunggakan->pembelian_id])}}">
          1-10 {{Carbon\Carbon::parse($tunggakan->tempo)->isoFormat('MMMM YYYY')}}
          </a>
      </td>
      <td data-order="{{bulanCicilanTunggakanBerjalan($tunggakan)}}">Rp. {{number_format(bulanCicilanTunggakanBerjalan($tunggakan))}}</td>
    </tr>
    @endif
    @empty
    <tr>
      <td>Tidak Ada Tunggakan</td>
    </tr>
    @endforelse
  </tbody>
  {{-- <tfoot>
      <tr class="bg-light">
        <th style="font-weight: bold; weight:20px" colspan="3" class="text-right text-primary">Total Estimasi Pendapatan : </th>
        <th style="font-weight: bold; weight:20px" class="text-primary">{{$totalDP}}</th>
        <th style="font-weight: bold; weight:20px" class="text-right text-primary">Total Realisasi : </th>
        <th style="font-weight: bold; weight:20px" class="text-primary">{{$totalDPTerbayar}}</th>
      </tr>
  </tfoot> --}}
</table>