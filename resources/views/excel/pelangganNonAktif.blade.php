<table class="table table-sm table-striped table-hover mt-3">
    <thead>
        <tr>
            <th style="font-weight: bold; weight:20px; font-size:22pt; text-align:center" colspan="7">Pelanggan
                Non-Aktif
            </th>
        </tr>
        <tr>
            <th style="width: 20pt;text-align:center;font-style:italic" colspan="7">{{ namaProyek() }}</th>
        </tr>
        <tr>
            <th style="font-weight: bold; weight:20px;text-align:right" scope="col">No</th>
            <th style="font-weight: bold; weight:20px" scope="col">Nama</th>
            <th style="font-weight: bold; weight:20px" scope="col">Blok</th>
            <th style="font-weight: bold; weight:20px" scope="col">Jenis</th>
            <th style="font-weight: bold; weight:20px" scope="col">Nomor Telepon</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pelangganNonAktif as $pelanggan)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $pelanggan->nama }}</td>
                @if ($pelanggan->kavling == null)
                    <td>Batal Akad</td>
                @else
                    <td>{{ $pelanggan->kavling->blok }}</td>
                @endif
                @if ($pelanggan->kavling == null)
                    <td>Batal Akad</td>
                @else
                    <td>{{ jenisKepemilikan($pelanggan->id) }}</td>
                @endif
                <td>{{ $pelanggan->nomorTelepon }}</td>
        @endforeach
    </tbody>
</table>
