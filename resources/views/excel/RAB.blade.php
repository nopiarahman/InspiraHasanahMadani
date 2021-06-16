
      <table>
        <thead>
          <tr>
            <th style="font-weight: bold; height:30pt; text-align:center; font-size:22pt" colspan="8">RAB</th>
          </tr>
          <tr>
            <th style="width: 20pt;text-align:center;font-style:italic" colspan="7">{{namaProyek()}}</th>
          </tr>
          <tr>
            {{-- <th style="width: 20pt;" colspan="7">Periode : {{Carbon\Carbon::parse($start)->isoFormat('DD MMMM Y')}} - {{Carbon\Carbon::parse($end)->isoFormat('DD MMMM Y')}}</th> --}}
          </tr>
          <tr></tr>
          <tr>
            <th scope="col" style="font-weight: bold; height:20pt">No</th>
            <th scope="col" style="font-weight: bold; height:20pt">Biaya</th>
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
              $a=[];
              $b=[];
              $perHeader=$semuaRAB;
              $perJudul=$semuaRAB;
          @endphp
          @foreach($perHeader as $header=>$semuaRAB)
          <tr>
            <th style="font-weight: bold; height:20pt" colspan="8">{{$loop->iteration}}. {{$header}}</th>
          </tr>
          @foreach($perJudul[$header] as $judul=>$semuaRAB)
          <tr>
            <th style="font-weight: bold; height:20pt" colspan="8" >{{$loop->iteration}}. {{$judul}}</th>
          </tr>
            @foreach($semuaRAB as $rab)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>{{$rab->isi}}</td>
              <td>{{$rab->volume}}</td>
              <td>{{$rab->satuan}}</td>
              <td>Rp.{{$rab->hargaSatuan}}</td>
              <th style="font-weight: bold; height:20pt">Rp.{{$rab->total}}</th>
              <th style="font-weight: bold; height:20pt">  Rp. {{hitungTransaksiRAB($rab->id)}}</th>
              <th style="font-weight: bold; height:20pt">
                @if($rab->total != 0)
                {{(float)(hitungTransaksiRAB($rab->id)/$rab->total*100),2}}%
                @else
                -
                @endif
              </th>
            </tr>
            @endforeach
            <tr >
              <th style="font-weight: bold; height:20pt" colspan="5">Sub Total {{$judul}}</th>
              <th style="font-weight: bold; height:20pt" colspan="3" >Rp. {{$semuaRAB->sum('total')}}</th>
            </tr>
            @php
                $a[]=$semuaRAB->sum('total'); /* menghitung per total judul */
                @endphp
            @endforeach
            <tr>
              <th style="font-weight: bold; height:20pt" colspan="5" >TOTAL {{$header}}</th>
              @php
                  $b[$header]=array_sum($a)-array_sum($b); /* menghitung total header */
                  @endphp
              <th style="font-weight: bold; height:20pt" colspan="3" >Rp. {{$b[$header]}}</th>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th style="font-weight: bold; height:20pt" colspan="5" >TOTAL RAB</th>
              <th style="font-weight: bold; height:20pt" colspan="3" >Rp. {{array_sum($b)}}</th>
          </tr>
        </tfoot>
      </table>