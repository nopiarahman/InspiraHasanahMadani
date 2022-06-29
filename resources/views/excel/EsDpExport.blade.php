<table class="table table-sm table-striped table-hover mt-3">
    <thead>
        <tr>
            <th style="font-weight: bold; weight:20px; font-size:22pt; text-align:center" colspan="7">Estimasi DP</th>
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
            $n = 1;
            $totalDP = 0;
            $totalDPTerbayar = 0;
        @endphp
        @foreach ($dpAktif as $dp)
            @if (cekDPLunasBulanan($dp, $start) === 'Cicilan')
                <tr>
                    <td>{{ $n, $n++ }}</td>
                    <td>{{ $dp->pelanggan->nama }} | {{ $dp->pelanggan->kavling->blok }}</td>
                    <td>{{ $dp->pelanggan->nomorTelepon }} </td>
                    @if ($dp->tenorDp === 0)
                        @php
                            $nilai = $dp->sisaDp;
                        @endphp
                    @else
                        @php
                            $nilai = $dp->dp / $dp->tenorDP;
                        @endphp
                    @endif
                    <td data-order="{{ $nilai }}">{{ $nilai }}</td>
                    @php
                        $totalDP += $nilai;
                    @endphp
                    <td> <a href="{{ route('DPKavlingTambah', ['id' => $dp->id]) }}">
                            @if (cekDpBulananTerbayar($dp, $start)->sum('jumlah') > 0)
                                {{ cekDpBulananTerbayar($dp, $start)->sum('jumlah') }}
                                @php
                                    $totalDPTerbayar += cekDpBulananTerbayar($dp, $start)->sum('jumlah');
                                @endphp
                            @elseif(cekDpSekaligus($dp, $start) != null)
                                s/d {{ formatBulanTahun(cekDpSekaligus($dp, $start)->tempo) }}
                            @else
                                <span class="text-danger">Belum bayar</span>
                            @endif
                        </a>
                    </td>
                    <td>
                        @if (cekDpTanggalTerbayar($dp, $start))
                            {{ formatTanggal(cekDpTanggalTerbayar($dp, $start)->tanggal) }}
                        @endif
                    </td>
                    @if ($dp->sisaDp - $dp->potonganDp <= 0)
                        <td> <span class="text-info">DP LUNAS</span> </td>
                    @else
                        <td>{{ $dp->sisaDp }}</td>
                    @endif
                </tr>
            @endif
        @endforeach
    </tbody>
    <tfoot>
        <tr class="bg-light">
            <th style="font-weight: bold; weight:20px" colspan="3" class="text-right text-primary">Total Estimasi
                Pendapatan : </th>
            <th style="font-weight: bold; weight:20px" class="text-primary">{{ $totalDP }}</th>
            <th style="font-weight: bold; weight:20px" class="text-right text-primary">Total Realisasi : </th>
            <th style="font-weight: bold; weight:20px" class="text-primary">{{ $totalDPTerbayar }}</th>
        </tr>
    </tfoot>
</table>
