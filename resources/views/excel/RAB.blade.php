<table>
    <thead>
        <tr>
            <th style="font-weight: bold; height:30pt; text-align:center; font-size:22pt" colspan="9">RAB</th>
        </tr>
        <tr>
            <th style="width: 20pt;text-align:center;font-style:italic" colspan="9">{{ namaProyek() }}</th>
        </tr>
        <tr>
            {{-- <th style="width: 20pt;" colspan="7">Periode : {{Carbon\Carbon::parse($start)->isoFormat('DD MMMM Y')}} - {{Carbon\Carbon::parse($end)->isoFormat('DD MMMM Y')}}</th> --}}
        </tr>
        <tr></tr>
        <tr>
            <th scope="col" style="font-weight: bold; height:20pt">No</th>
            <th scope="col" colspan="2" style="font-weight: bold; height:20pt">Biaya</th>
            <th scope="col" style="font-weight: bold; height:20pt">Volume</th>
            <th scope="col" style="font-weight: bold; height:20pt">Satuan</th>
            <th scope="col" style="font-weight: bold; height:20pt">Harga Satuan</th>
            <th scope="col" style="font-weight: bold; height:20pt">Total</th>
            <th scope="col" style="font-weight: bold; height:20pt">Pengeluaran</th>
            <th scope="col" style="font-weight: bold; height:20pt">Persentase</th>
        </tr>
    </thead>
    <tbody>
        @php
            $a = [];
            $bRAB = [];
            $perHeader = $semuaRAB;
            $perJudul = $semuaRAB;
        @endphp
        @foreach ($perHeader as $header => $semuaRAB)
            <tr>
                <th style="font-weight: bold; height:20pt" colspan="8">{{ $header }}</th>
            </tr>
            @foreach ($perJudul[$header] as $judul => $semuaRAB)
                <tr>
                    <th style="font-weight: bold; height:20pt" colspan="8">{{ $loop->iteration }}.
                        {{ $judul }}
                    </th>
                </tr>
                @foreach ($semuaRAB as $rab)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td colspan="2">{{ $rab->isi }}</td>
                        <td>{{ $rab->volume }}</td>
                        <td>{{ $rab->satuan }}</td>
                        <td>{{ $rab->hargaSatuan }}</td>
                        <th style="font-weight: bold; height:20pt">{{ $rab->total }}</th>
                        <th style="font-weight: bold; height:20pt"> {{ hitungTransaksiRAB($rab->id) }}</th>
                        <th style="font-weight: bold; height:20pt">
                            @if ($rab->total != 0)
                                {{ round((hitungTransaksiRAB($rab->id) / $rab->total) * 100, 2) }}%
                            @else
                                -
                            @endif
                        </th>
                    </tr>
                @endforeach
                <tr>
                    <th style="font-weight: bold; height:20pt" colspan="6">Sub Total {{ $judul }}</th>
                    <th style="font-weight: bold; height:20pt" colspan=""> {{ $semuaRAB->sum('total') }}</th>
                    <th style="font-weight: bold; height:20pt">{{ transaksiRAB($judul) }}</th>
                    <th style="font-weight: bold; height:20pt">
                        @if ($semuaRAB->sum('total') != 0)
                            {{ round((transaksiRAB($judul) / $semuaRAB->sum('total')) * 100, 2) }}%
                        @endif
                    </th>
                </tr>
                @php
                    $a[] = $semuaRAB->sum('total'); /* menghitung per total judul */
                @endphp
            @endforeach
            <tr>
                <th style="font-weight: bold; height:20pt" colspan="6">TOTAL {{ $header }}</th>
                @php
                    $bRAB[$header] = array_sum($a) - array_sum($bRAB); /* menghitung total header */
                @endphp
                <th style="font-weight: bold; height:20pt" colspan=""> {{ $bRAB[$header] }}</th>
                <th style="font-weight: bold; height:20pt">{{ transaksiRABHeader($header) }}</th>
                <th style="font-weight: bold; height:20pt">
                    @if ($bRAB[$header] != 0)
                        {{ round((transaksiRABHeader($header) / $bRAB[$header]) * 100, 2) }}%
                    @endif
                </th>
            </tr>
        @endforeach
    </tbody>
    {{-- <tfoot>
            <tr>
              <th style="font-weight: bold; height:20pt" colspan="5" >TOTAL RAB</th>
              <th style="font-weight: bold; height:20pt" colspan="3" > {{array_sum($bRAB)}}</th>
          </tr>
        </tfoot> --}}
    {{-- <thead>
          <tr>
            <th style="font-weight: bold; height:30pt; font-size:22pt; text-align:center" colspan="8"> RAB UNIT</th>
          </tr>
          <tr>
            <th style="width: 20pt;text-align:center;font-style:italic" colspan="7">{{namaProyek()}}</th>
          </tr>
          <tr>
          </tr>
          <tr></tr>
          <tr>
            <th style="font-weight: bold; height:20pt" scope="col">No</th>
            <th style="font-weight: bold; height:20pt" scope="col">Biaya</th>
            <th style="font-weight: bold; height:20pt" scope="col">Jenis</th>
            <th style="font-weight: bold; height:20pt" scope="col">Volume</th>
            <th style="font-weight: bold; height:20pt" scope="col">Satuan</th>
            <th style="font-weight: bold; height:20pt" scope="col">Harga Satuan</th>
            <th style="font-weight: bold; height:20pt" scope="col">Total</th>
            <th style="font-weight: bold; height:20pt" scope="col">Pengeluaran</th>
            <th style="font-weight: bold; height:20pt" scope="col">Persentase</th>
          </tr>
        </thead> --}}
    <tbody>
        @php
            $a = [];
            $b = [];
            $c = [];
            $totalIsi = [];
            $perHeaderUnit = $semuaUnit;
            $perJudulUnit = $semuaUnit;
        @endphp
        @foreach ($perHeaderUnit as $header => $semuaUnit)
            <tr>
                <th style="font-weight: bold; height:20pt" colspan="9"> {{ $header }}</th>
            </tr>
            @foreach ($perJudulUnit[$header] as $judul => $semuaUnit)
                @php
                    $a[$judul] = 0;
                    $c[$judul] = 0;
                    $totalIsi[$judul] = 0;
                @endphp
                <tr>
                    <th style="font-weight: bold; height:20pt" colspan="9">{{ $loop->iteration }}.
                        {{ $judul }}
                    </th>
                </tr>
                @foreach ($semuaUnit->sortBy('isi', SORT_NATURAL) as $rab)
                    <tr>
                        <td style="height:20pt">{{ $loop->iteration }}</td>
                        <td style="height:20pt">{{ $rab->isi }}</td>
                        <td style="height:20pt">{{ $rab->jenisUnit }}</td>
                        @if ($rab->header == 'BIAYA PRODUKSI RUMAH')
                            <td style="height:20pt">
                                {{ hitungUnit($rab->isi, $rab->judul, $rab->jenisUnit) }}</td>
                        @else
                            <td style=" height:20pt">{{ $rab->volume }}</td>
                        @endif
                        <td style="height:20pt">{{ satuanUnit($rab->judul) }}</td>
                        <td style="height:20pt">{{ (int) $rab->hargaSatuan }}</td>
                        @if ($rab->header == 'BIAYA PRODUKSI RUMAH')
                            <td style="height:20pt">Rp.
                                {{ number_format(hitungUnit($rab->isi, $rab->judul, $rab->jenisUnit) * (int) $rab->hargaSatuan) }}
                            </td>
                        @else
                            <th style=" height:20pt">{{ $rab->volume * (int) $rab->hargaSatuan }}
                            </th>
                        @endif
                        @if ($rab->header == 'BIAYA PRODUKSI RUMAH')
                            @php
                                $totalIsi[$judul] = hitungUnit($rab->isi, $rab->judul, $rab->jenisUnit) * (int) $rab->hargaSatuan + $totalIsi[$judul];
                            @endphp
                        @else
                            @php
                                $totalIsi[$judul] = $rab->volume * (int) $rab->hargaSatuan + $totalIsi[$judul];
                            @endphp
                        @endif
                        <th style="font-weight: bold; height:20pt"> {{ hitungTransaksiRABUnit($rab->id) }}</th>
                        <th style="font-weight: bold; height:20pt">
                            @if ((int) $rab->hargaSatuan != 0 && $rab->volume != 0)
                                {{ (float) ((hitungTransaksiRABUnit($rab->id) / $rab->volume) * (int) $rab->hargaSatuan * 100), 2 }}%
                            @else
                                -
                            @endif
                        </th>
                    </tr>
                @endforeach
                @php
                    $a[$judul] = $totalIsi[$judul];
                @endphp
                @php
                    $c[$judul] = $a[$judul] - $c[$judul];
                @endphp
                <tr>
                    <th style="font-weight: bold; height:20pt" colspan="6">Sub Total {{ $judul }}</th>
                    <th style="font-weight: bold; height:20pt"> {{ $c[$judul] }}</th>
                </tr>
            @endforeach
            @php
                $b[$header] = array_sum($c) - array_sum($b); /* menghitung total header */
            @endphp
            <tr>
                <th style="font-weight: bold; height:20pt" colspan="6">TOTAL {{ $header }}</th>
                <th style="font-weight: bold; height:20pt"> {{ $b[$header] }}</th>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th style="font-weight: bold; height:20pt" colspan="6">TOTAL RAB</th>
            <th style="font-weight: bold; height:20pt"> {{ array_sum($b) + array_sum($bRAB) }}</th>
        </tr>
    </tfoot>
</table>
