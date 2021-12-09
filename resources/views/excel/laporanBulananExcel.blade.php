<table>
    <tr>
      <th style="width: 20pt; font-weight:bold;font-size:22pt;text-align:center;" colspan="3">Laporan Bulanan</th>
    </tr>
    <tr>
      <th style="width: 20pt;text-align:center;font-style:italic" colspan="3">{{namaProyek()}}</th>
    </tr>
    <tr>
      <th style="width: 20pt;text-align:center;font-style:italic" colspan="3">Periode : {{Carbon\Carbon::parse($start)->isoFormat('DD MMMM Y')}} - {{Carbon\Carbon::parse($end)->isoFormat('DD MMMM Y')}}</th>
    </tr>
    <tr></tr>
    <tbody>
    <tr>
      <th style="width: 20pt;font-weight:bold;" scope="col" colspan="3" >Modal</th>
    </tr>
    <tr>
      <td></td>
      <th>Modal Tahun Sebelumnya</th>
      <th>{{$mts}}</th>
    </tr>
    @php
        $b=[];
    @endphp
    @forelse ($bulan as $single=>$a)
    <tr>
      <td>{{$loop->iteration}}</td>
      <td >Modal Bulan {{Carbon\Carbon::parse($a->first()->tanggal)->isoFormat('MMMM')}}</td>
      <td>
        {{$a->sum('kredit')}}
        @php
            $b[]=$a->sum('kredit');
        @endphp
      </td>
    </tr>              
    @empty
    @endforelse
    <tr>
      <td></td>
      <th>Total Modal Tahun {{Carbon\Carbon::parse($tahuniniStart)->isoFormat('YYYY')}}</th>
      <th>{{array_sum($b)}}</th>
    </tr>
    <tr>
      <td></td>
      <th>Total Modal</th>
      <th>{{array_sum($b)+(int)$mts}}</th>
    </tr>
    <tr>
      <th style="width: 20pt;font-weight:bold;" scope="col" colspan="3" >Aset</th>
    </tr>
    <tr>
      <td></td>
      <th>Aset Tahun Sebelumnya</th>
      <th>{{$ats}}</th>
    </tr>
    @php
        $c=[];
    @endphp
    @foreach($transaksiAset as $single2=>$b2)
    <tr>
      <td>{{$loop->iteration}}</td>
      <th >Aset Bulan {{Carbon\Carbon::parse($b2->first()->tanggal)->isoFormat('MMMM')}}</th>
      <th>
        {{$b2->sum('debet')}}
        @php
            $c[]=$b2->sum('debet');
        @endphp
      </th>
    </tr>              
    @endforeach
    <tr>
      <td></td>
      <th>Total Aset Tahun {{Carbon\Carbon::parse($tahuniniStart)->isoFormat('YYYY')}}</th>
      <th>{{array_sum($c)}}</th>
    </tr>
    <tr>
      <td></td>
      <th>Total Aset</th>
      <th>{{array_sum($c)+$ats}}</th>
    </tr>
    <tr>
      <th style="width: 20pt;font-weight:bold;" scope="col" colspan="3" >Pendapatan</th>
    </tr>
    @foreach($pendapatan as $pd)
    <tr>
      <td>{{$loop->iteration}}</td>
      <td>{{$pd->uraian}}</td>
      <td>{{$pd->kredit}}</td>
    </tr>
    @endforeach
    <tr >
      <th colspan="2">Pendapatan Bulan {{\Carbon\carbon::parse($start)->isoFormat('MMMM')}}</th>
      @if($pendapatan !=null)
      <th>{{$pendapatan->sum('kredit')}}</th>
      @else
      <th></th>
      @endif
    </tr>
    <tr>
      <th colspan="2">Sisa Saldo Bulan {{\Carbon\carbon::parse($start)->firstOfMonth()->subMonths(1)->isoFormat('MMMM')}}</th>
      <th>{{saldoBulanSebelumnya($start)}}</th>
    </tr>
    <tr>
      <th colspan="2" style="width: 20pt;font-weight:bold;">Total Pendapatan</th>
      @if($pendapatan !=null)
      <th>{{saldoBulanSebelumnya($start)+$pendapatan->sum('kredit')}}</th>
      @else
      <th></th>
      @endif
    </tr>
    <tr></tr>

    <tr>
      <th style="width: 20pt;font-weight:bold;" scope="col" colspan="3" >Pengeluaran</th>
    </tr>
    @php
        $a=[];
        $bRAB=[];
        $perHeader=$semuaRAB;
        $perJudul=$semuaRAB;
        $perHeaderUnit=$semuaUnit;
        $perJudulUnit=$semuaUnit;
    @endphp
    @foreach($perHeader as $header=>$semuaRAB)
    <tr>
      <th colspan="3" style="width: 20pt;font-weight:bold;">{{$header}}</th>
    </tr>
    @php
        $y=1;
    @endphp
    @foreach($perJudul[$header] as $judul=>$semuaRAB)
    @if(hitungJudulRAB($judul,$start,$end) >0)

    @php
        $a[$judul]=0;
        $c[$judul]=0;
        $totalIsi[$judul]=0;
    @endphp
    <tr>
      <th colspan="3" >{{$loop->iteration}}. {{$judul}}</th>
    </tr>
      @foreach($semuaRAB as $rab)
      @if(hitungTransaksiRABRange($rab->id,$start,$end) >0)
      <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$rab->isi}}</td>
        <th>{{hitungTransaksiRABRange($rab->id,$start,$end)}}</th>
        @php
            $totalIsi[$judul]+=hitungTransaksiRABRange($rab->id,$start,$end);
        @endphp
      </tr>
      @endif
      @endforeach
      @php
        $a[$judul]=$totalIsi[$judul]
      @endphp
      @php
          $c[$judul]=$a[$judul]-$c[$judul];
      @endphp
      <tr>
        <th colspan="2">Sub Total {{$judul}}</th>
        <th>{{$c[$judul]}}</th>
      </tr>
      @endif
      @endforeach
      <tr>
        <th style="width: 20pt;font-weight:bold;" colspan="2">TOTAL {{$header}}</th>
        @php
            $bRAB[$header]=array_sum($a)-array_sum($bRAB); /* menghitung total header */
            @endphp
        <th>{{$bRAB[$header]}}</th>
      </tr>
      @endforeach
      {{-- RAB UNIT --}}
      @php
          $a=[];
          $b=[];
          $c=[];
          $totalIsi=[];
      @endphp
      @foreach($perHeaderUnit as $header=>$semuaUnit)
      <tr>
        <th style="width: 20pt;font-weight:bold;" colspan="3"> {{$header}}</th>
      </tr>
    @foreach($perJudulUnit[$header] as $judul=>$semuaUnit)
    @php
        $a[$judul]=0;
        $c[$judul]=0;
        $totalIsi[$judul]=0;
    @endphp
      <tr>
        <th colspan="3" >{{$loop->iteration}}. {{$judul}}</th>
      </tr>
      @foreach($semuaUnit->sortBy('isi',SORT_NATURAL) as $rab)
      @if(hitungTransaksiRABUnitRange($rab->id,$start,$end)>0)
      <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$rab->isi}}</td>
        <th >{{hitungTransaksiRABUnitRange($rab->id,$start,$end)}}</th>
        @php
            $totalIsi[$judul]+=hitungTransaksiRABUnitRange($rab->id,$start,$end);
        @endphp
      </tr>
      @endif
      @endforeach
      @php
        $a[$judul]=$totalIsi[$judul]
      @endphp
      @php
          $c[$judul]=$a[$judul]-$c[$judul];
      @endphp
      <tr>
        <th colspan="2" >Sub Total {{$judul}}</th>
        <th>{{$c[$judul]}}</th>
      </tr>
      @endforeach
        @php
            $b[$header]=array_sum($c)-array_sum($b); /* menghitung total header */
        @endphp
      <tr>
        <th colspan="2">TOTAL {{$header}}</th>
        <th>{{$b[$header]}}</th>
      </tr>
      @endforeach
  </tbody>
  <tfoot>
    <tr>
      <th  style="width: 20pt;font-weight:bold;" colspan="2" >TOTAL PENGELUARAN</th>
      <th  style="width: 20pt;font-weight:bold;">{{array_sum($b)+array_sum($bRAB)}}</th>
    </tr>
    <tr>
      <th  style="width: 20pt;font-weight:bold;" colspan="2" >LABA/RUGI Berjalan</th>
      <th  style="width: 20pt;font-weight:bold;">{{saldoBulanSebelumnya($start)+$pendapatan->sum('kredit')-(array_sum($b)+array_sum($bRAB))}}</th>
    </tr>
  </tfoot>
</table>