<table class="table table-sm table-hover table-striped">
  <thead>
    <tr>
      <th style="width: 20pt; font-weight:bold;font-size:22pt;text-align:center;" colspan="2">Laporan Tahunan</th>
    </tr>
    <tr>
      <th style="width: 20pt;text-align:center;font-style:italic" colspan="2">{{namaProyek()}}</th>
    </tr>
    <tr>
      <th style="width: 20pt;" colspan="2">Periode : {{Carbon\Carbon::parse($start)->isoFormat('DD MMMM Y')}} - {{Carbon\Carbon::parse($end)->isoFormat('DD MMMM Y')}}</th>
    </tr>
    <tr></tr>
    <tr>
      <th style="width: 20pt;font-weight:bold;" scope="col" colspan="2" >Pendapatan</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th style="width: 20pt;font-weight:bold" colspan="2" class="pt-3 bg-success text-white">Pendapatan</th>
    </tr>
    <tr>
      <th style="width: 20pt;font-weight:bold" colspan="2" class="">A. Pendapatan Usaha</th>
    </tr>
    <tr>
      <td style="width: 20pt" class="pl-4">Penjualan</td>
      <td style="width: 20pt">Rp. {{number_format(penjualanTahunan($start,$end))}}</td>
    </tr>
    <tr>
      <th style="width: 20pt;font-weight:bold" colspan="2" class="">B. Pendapatan Lain-lain</th>
    </tr>
    @if($pendapatanLain->first() != null)
    @foreach ($pendapatanLain as $produk)
      <tr>
        <td style="width: 20pt" class="pl-4">{{$produk->namaAkun}}</td>
        <td style="width: 20pt" >Rp. {{number_format(pendapatanLainTahunan($produk->id,$start,$end))}}</td>
      </tr>
    @endforeach
    <tr class="border border-success">
      
    <th style="width: 20pt;font-weight:bold" >Total Pendapatan</th>
    <th style="width: 20pt;font-weight:bold" class="">Rp. {{number_format(penjualanTahunan($start,$end)+pendapatanLainTahunan($produk->id,$start,$end))}}</th>
  </tr>
    <tr>
      <th style="width: 20pt;font-weight:bold" colspan="2" class="">Biaya Atas Pendapatan</th>
    </tr>
    <tr>
      <th style="width: 20pt;font-weight:bold" colspan="2" class="">A. Biaya Produksi</th>
    </tr>
    @endif
    @php
        $totalProduksi = 0;
        $totalOperasional = 0;
        $totalNonOperasional = 0;
    @endphp
    @foreach ($produksi as $produk)
      <tr>
        <td style="width: 20pt" class="pl-4">{{$produk->namaAkun}}</td>
        <td style="width: 20pt">Rp. {{number_format(transaksiAkunTahunan($produk->id,$start,$end))}}</td>
      </tr>
      @php
          $totalProduksi += transaksiAkunTahunan($produk->id,$start,$end);
      @endphp
    @endforeach
    <tr>
      <td style="width: 20pt" class="pl-4">Biaya Pembangunan Rumah </td>
      <td style="width: 20pt">Rp. {{number_format(biayaPembangunanRumahTahunan($start,$end))}}</td>
    </tr>
    <tr>
      <td style="width: 20pt" class="pl-4">Biaya Pembebanan Per-Unit </td>
      <td style="width: 20pt">Rp. {{number_format(biayaPembebananTahunan($start,$end))}}</td>
    </tr>
    <tr class="border border-success">
      <th style="width: 20pt;font-weight:bold" class="border-top">Total Biaya Produksi</th>
      <th style="width: 20pt;font-weight:bold" class="border-top">Rp. {{number_format($totalProduksi+biayaPembebananTahunan($start,$end)+biayaPembangunanRumahTahunan($start,$end))}}</th>
    </tr>
    <tr>
      <th style="width: 20pt;font-weight:bold" class="bg-secondary">Laba Kotor</th>
      <th style="width: 20pt;font-weight:bold" class="bg-secondary">
        Rp. {{number_format((penjualanTahunan($start,$end)+pendapatanLainTahunan($produk->id,$start,$end))-($totalProduksi+biayaPembebananTahunan($start,$end)+biayaPembangunanRumahTahunan($start,$end)))}}
      </th>
    </tr>
    <tr>
      <th style="width: 20pt;font-weight:bold" colspan="2" class="pt-3 bg-success text-white">Pengeluaran Operasional</th>
    </tr>
    <tr>
      <th style="width: 20pt;font-weight:bold" colspan="2" class="">A. Biaya Operasional</th>
    </tr>
    @foreach ($operasional as $produk)
      <tr>
        <td style="width: 20pt" class="pl-4">{{$produk->namaAkun}}</td>
        <td style="width: 20pt">Rp. {{number_format(transaksiAkunTahunan($produk->id,$start,$end))}}</td>
      </tr>
      @php
          $totalOperasional += transaksiAkunTahunan($produk->id,$start,$end);
      @endphp
    @endforeach
    <tr class="border border-success">
      <th style="width: 20pt;font-weight:bold" class="">Total Biaya Operasional</th>
      <th style="width: 20pt;font-weight:bold" class="">Rp. {{number_format($totalOperasional)}}</th>
    </tr>
    <tr >
      <th style="width: 20pt;font-weight:bold" colspan="2" class="">B. Biaya Non Operasional</th>
    </tr>
    @foreach ($nonOperasional as $produk)
      <tr>
        <td style="width: 20pt" class="pl-4">{{$produk->namaAkun}}</td>
        <td style="width: 20pt">Rp. {{number_format(transaksiAkunTahunan($produk->id,$start,$end))}}</td>
      </tr>
      @php
          $totalNonOperasional += transaksiAkunTahunan($produk->id,$start,$end);
      @endphp
    @endforeach
    <tr class="border border-success">
      <th style="width: 20pt;font-weight:bold" class="">Total Biaya Non Operasional</th>
      <th style="width: 20pt;font-weight:bold" class="">Rp. {{number_format($totalNonOperasional)}}</th>
    </tr>
    <tr class="border border-success">
      <th style="width: 20pt;font-weight:bold" class="bg-secondary">Total Pengeluaran Operasional</th>
      <th style="width: 20pt;font-weight:bold" class="bg-secondary">Rp. {{number_format($totalNonOperasional+$totalOperasional)}}</th>
    </tr>
    <tr>
      <th style="width: 20pt;font-weight:bold" class="bg-warning text-white">Laba/Rugi Operasional</th>
      <th style="width: 20pt;font-weight:bold" class="bg-warning text-white">Rp. {{number_format(((penjualanTahunan($start,$end)+pendapatanLainTahunan($produk->id,$start,$end))-($totalProduksi+biayaPembebananTahunan($start,$end)+biayaPembangunanRumahTahunan($start,$end)))-($totalNonOperasional+$totalOperasional))}}</th>
    </tr>
  </tbody>
</table>