<table class="table table-sm table-striped table-hover mt-3">
    <thead>
        <tr>
            <th style="font-weight: bold; weight:20px; font-size:22pt; text-align:center" colspan="7">Pengadaan Barang
                {{ $id->deskripsi }}</th>
        </tr>
        <tr>
            <th style="width: 20pt;text-align:center;font-style:italic" colspan="7">{{ namaProyek() }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; weight:20px;text-align:right" scope="col">No</th>
            <th style="font-weight: bold; weight:20px" scope="col">Nama Barang</th>
            <th style="font-weight: bold; weight:20px" scope="col">Merek</th>
            <th style="font-weight: bold; weight:20px" scope="col">Jumlah Barang</th>
            <th style="font-weight: bold; weight:20px" scope="col">Estimasi Harga</th>
            <th style="font-weight: bold; weight:20px" scope="col">Keterangan</th>
            <th style="font-weight: bold; weight:20px" scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($semuaIsi as $isi)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $isi->namaBarang }}</td>
                <td>{{ $isi->merek }}</td>
                <td>{{ $isi->jumlahBarang }} {{ $isi->satuan }}</td>
                <td>{{ $isi->totalHarga }}</td>
                <td>{{ $isi->keterangan }}</td>
                <td>
                    @if ($isi->status == 0)
                        <span class="badge badge-primary">Baru</span>
                    @elseif($isi->status == 1)
                        <span class="badge badge-info text-white">Diterima</span>
                    @elseif($isi->status == 2)
                        <span class="badge badge-warning text-danger">Ditolak</span>
                    @endif
                </td>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4" style="font-weight: bold; weight:20px" class="text-right text-primary">Total Estimasi
                Harga</th>
            <th style="font-weight: bold; weight:20px" class="text-primary">{{ $semuaIsi->sum('totalHarga') }}</th>
        </tr>
</table>
