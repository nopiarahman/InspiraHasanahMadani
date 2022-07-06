<table class="table table-sm table-striped table-hover mt-3">
    <thead>
        <tr>
            <th style="font-weight: bold; weight:20px; font-size:22pt; text-align:center" colspan="7">Transaksi Keluar
            </th>
        </tr>
        <tr>
            <th style="width: 20pt;text-align:center;font-style:italic" colspan="7">{{ namaProyek() }}</th>
        </tr>
        <tr>
            <th style="width: 20pt;" colspan="7">Periode : {{ Carbon\Carbon::parse($start)->isoFormat('DD MMMM Y') }} -
                {{ Carbon\Carbon::parse($end)->isoFormat('DD MMMM Y') }}</th>
        </tr>
        <tr></tr>
        <tr>
            <th style="font-weight: bold; weight:20px" scope="col">Tanggal</th>
            <th style="font-weight: bold; weight:20px" scope="col">Kode Transaksi</th>
            <th style="font-weight: bold; weight:20px" scope="col">Uraian</th>
            <th style="font-weight: bold; weight:20px" scope="col">Jumlah</th>
            <th style="font-weight: bold; weight:20px" scope="col">Sumber</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transaksiKeluar as $transaksi)
            <tr>

                <td data-order="{{ $transaksi->tanggal }}">{{ formatTanggal($transaksi->tanggal) }}</td>
                <td>
                    @if ($transaksi->rab)
                        {{ $transaksi->rab->kodeRAB }}
                    @elseif($transaksi->rabUnit)
                        {{ $transaksi->rabUnit->kodeRAB }}
                    @endif
                </td>
                <td>{{ $transaksi->uraian }} {{ $transaksi->jumlah }} {{ $transaksi->satuan }}</td>
                <td data-order="{{ $transaksi->debet }}">{{ $transaksi->debet }}</td>
                <td>{{ $transaksi->sumber }}</td>
                {{-- @if ($transaksi->sumber != 'Gudang')
      <td>
        @if (cekGudang($transaksi->id) == 'ada')
          <a href="{{route('gudang')}}" type="button" class="btn btn-sm btn-white text-primary border-success">
          <i class="fas fa-warehouse "></i> Ada Stok Gudang</a>
        @elseif(cekGudang($transaksi->id) == "habis")
          <a href="{{route('gudang')}}" type="button"  class=" disabled btn btn-sm btn-white text-primary border-success">
          <i class="fas fa-warehouse "></i> Stok Gudang Habis </a>
        @else
        <button type="button" class="btn btn-sm btn-white text-primary border-success" 
        data-toggle="modal" 
        data-target="#keGudang" 
        data-id="{{$transaksi->id}}" 
        data-tanggal="{{$transaksi->tanggal}}" 
        data-uraian="{{$transaksi->uraian}}" 
        data-jumlah="{{$transaksi->jumlah}}" 
        data-satuan="{{$transaksi->satuan}}" 
        data-harga="{{$transaksi->hargaSatuan}}" 
        data-total="{{$transaksi->debet}}" 
        data-awal="@if ($transaksi->rab){{$transaksi->rab->kodeRAB}}@elseif($transaksi->rabUnit){{$transaksi->rabUnit->kodeRAB}}@endif" 
        >
        Sisa Barang</button>
        @endif
        @endif
        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'projectmanager' || auth()->user()->role == 'marketing')
        <button type="button" class="btn btn-sm btn-white text-danger border-danger" 
        data-toggle="modal" 
        data-target="#hapusTransaksi" 
        data-id="{{$transaksi->id}}" 
        data-uraian="{{$transaksi->uraian}}">
        <i class="fa fa-trash" aria-hidden="true" ></i> Hapus</button>
      </td>
      @endif --}}
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3" class="text-right text-primary">Total Transaksi</th>
            <th colspan="2" class="text-primary">Rp. {{ number_format($transaksiKeluar->sum('debet')) }}</th>
        </tr>
</table>
