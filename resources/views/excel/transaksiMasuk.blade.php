<table class="table table-sm table-striped table-hover mt-3">
    <thead>
        <tr>
            <th style="font-weight: bold; weight:20px; font-size:22pt; text-align:center" colspan="7">Transaksi Masuk
            </th>
        </tr>
        <tr>
            <th style="width: 20pt;text-align:center;font-style:italic" colspan="7">{{ namaProyek() }}</th>
        </tr>
        <tr>
            <th style="width: 20pt;" colspan="7">Periode : {{ Carbon\Carbon::parse($start)->isoFormat('DD MMMM Y') }}
                -
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
        @foreach ($transaksiMasuk as $transaksi)
            <tr>
                <td data-order="{{ $transaksi->tanggal }}">{{ formatTanggal($transaksi->tanggal) }}</td>
                <td>
                    @if ($transaksi->rab)
                        {{ $transaksi->rab->kodeRAB }}
                    @elseif($transaksi->rabUnit)
                        {{ $transaksi->rabUnit->kodeRAB }}
                    @endif
                    {{ $transaksi->kategori }}
                </td>
                <td>{{ $transaksi->uraian }}</td>
                <td data-order="{{ $transaksi->kredit }}">{{ $transaksi->kredit }}</td>
                <td>{{ $transaksi->sumber }}</td>
                {{-- <td><a href="#" class="badge badge-primary">Detail</a></td> --}}
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3" class="text-right text-primary">Total Transaksi</th>
            <th class="text-primary">{{ $transaksiMasuk->sum('kredit') }}</th>
        </tr>
</table>
