
      <table>
        <thead>
          <tr>
            <th style="font-weight: bold; height:30pt; text-align:center; font-size:22pt" colspan="6">Pengeluaran {{$id->isi}}</th>
          </tr>
          <tr>
            <th style="width: 20pt;text-align:center;font-style:italic" colspan="6">{{namaProyek()}}</th>
          </tr>
          <tr>
            @if ($bulanTerpilih == 0)
            <th style="width: 20pt;text-align:center;font-style:italic" colspan="6">Semua Pengeluaran</th>
            @else
            <th style="width: 20pt;text-align:center;font-style:italic" colspan="6">Bulan {{$bulanTerpilih}}</th>
            @endif
            {{-- <th style="width: 20pt;" colspan="7">Periode : {{Carbon\Carbon::parse($start)->isoFormat('DD MMMM Y')}} - {{Carbon\Carbon::parse($end)->isoFormat('DD MMMM Y')}}</th> --}}
          </tr>
          <tr></tr>
          <tr>
            <th scope="col" style="font-weight: bold; height:20pt">No</th>
            <th scope="col" style="font-weight: bold; height:20pt">Tanggal</th>
            <th scope="col" style="font-weight: bold; height:20pt">Kode Transaksi</th>
            <th scope="col" style="font-weight: bold; height:20pt">Uraian</th>
            <th scope="col" style="font-weight: bold; height:20pt">Jumlah</th>
            <th scope="col" style="font-weight: bold; height:20pt">Sumber</th>
            {{-- <th scope="col" style="font-weight: bold; height:20pt">Pengeluaran</th>
            <th scope="col" style="font-weight: bold; height:20pt">Persentase</th> --}}
          </tr>
        </thead>
        <tbody>
          @foreach($transaksiKeluar->sortBy('tanggal',SORT_NATURAL) as $transaksi)
          <tr>
            <td>{{$loop->iteration}}</td>
            <td data-order="{{$transaksi->tanggal}}" >{{formatTanggal($transaksi->tanggal)}}</td>
            <td>
              @if($transaksi->rab)
            {{$transaksi->rab->kodeRAB}}
            @elseif($transaksi->rabUnit)
            {{$transaksi->rabUnit->kodeRAB}}
            @endif
            {{$transaksi->kategori}}
            </td>
            <td>{{$transaksi->uraian}}</td>
            <td>Rp.{{number_format($transaksi->debet)}}</td>
            <td>{{$transaksi->sumber}}</td>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="4" style="text-align: right; font-weight:bold;" class="text-primary"> <h5> Total:</h5></td>
            <td style="font-weight:bold;" class="text-primary"> <h5> {{number_format($totalFilter)}}</h5></td>
          </tr>
        </tfoot>
      </table>
