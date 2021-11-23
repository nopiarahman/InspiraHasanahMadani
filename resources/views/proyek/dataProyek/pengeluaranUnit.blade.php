@extends('layouts.tema')
@section('head')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endsection
@section ('menuRAB','active')
@section ('menuDataProyek','active')
@section('content')
<div class="section-header sticky-top">
  <div class="container">
    <div class="row">
      <div class="col">
        <h1>Pengeluaran {{$id->isi}}</h1>
      </div>
      <div class="kanan">
        @if($id->getTable() =='rab')
        <form action="{{route('cetakPengeluaranRAB',['id'=>$id->id])}}" method="get">
          @csrf
          @if ($bulanTerpilih == 0)
          @else
          <input type="hidden" name="bulan" value="{{$bulanTerpilih}}">
          @endif
          <button type="submit" class="btn btn-primary"> <i class="fas fa-file-excel"></i> Export Excel</button>
        </form>
        @elseif($id->getTable()=='rabunit')
        <form action="{{route('cetakPengeluaranUnit',['id'=>$id->id])}}" method="get">
          @csrf
          @if ($bulanTerpilih == 0)
          @else
          <input type="hidden" name="bulan" value="{{$bulanTerpilih}}">
          @endif
          <button type="submit" class="btn btn-primary"> <i class="fas fa-file-excel"></i> Export Excel</button>
        </form>
        @endif
      </div>
    </div>

    <div class="row">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb  bg-white mb-n2">
          <li class="breadcrumb-item"> <a href="{{route('RAB')}}"> RAB </a></li>
          {{-- <li class="breadcrumb-item"> <a href="{{route('biayaUnit')}}"> Biaya Unit </a></li> --}}
          <li class="breadcrumb-item" aria-current="page"> Pengeluaran </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<div class="section-header">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <h6 class="text-primary">Total RAB</h6>
      </div>
      <div class="col-md-3">
        <h6>: Rp.{{number_format($totalRAB)}}</h6>
      </div>
      <div class="col-md-3">
        <h6 class="text-primary">Total Pengeluaran</h6>
      </div>
      <div class="col-md-3">
        <h6 class="text-warning">: Rp.{{number_format($total->sum('debet'))}}</h6>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6"></div>
      <div class="col-md-3">
        <h6 class="text-primary">Persentase</h6>
      </div>
      <div class="col-md-3">
        @if($totalRAB != 0)
        <h6>: {{number_format((float)($total->sum('debet')/$totalRAB*100),2)}}%</h6>
        @else
        <h6>: 0%</h6>
        @endif
      </div>
    </div>
  </div>
</div>
    {{-- Alert --}}
    <div class="row">
      <div class="col-12">
        @if (session('status'))
          <div class="alert alert-success alert-dismissible show fade">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            {{session ('status')}}
          </div>
        @endif
        @if (session('error'))
          <div class="alert alert-warning alert-dismissible show fade">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            {{session ('error')}}
          </div>
        @endif
      </div>
    </div>
<div class="card">
    <div class="card-header">
      <h4>Daftar Pengeluaran {{$id->isi}}</h4>
    </div>
    <div class="card-body">
      {{-- filter --}}
      <div class="row form-group">
        <div class="col">
          @if($id->getTable() =='rab')
          <form action="{{route('transaksiRAB',['id'=>$id->id])}}" method="get" enctype="multipart/form-data">
          @elseif($id->getTable()=='rabunit')
          <form action="{{route('transaksiRABUnit',['id'=>$id->id])}}" method="get" enctype="multipart/form-data">
          @endif
            <select class="form-control col-md-8" name="bulan" id=""  onchange="this.form.submit()">
              <option value="" @if ($bulanTerpilih ===0)
                  selected
              @endif>Semua Pengeluaran</option>
              @forelse ($periode as $p)
                  <option value="{{$p}}" @if ($bulanTerpilih ===$p)
                      selected
                  @endif>{{filterBulan($p)}}</option>
              @empty
              @endforelse
            </select> 
          </form> 
        </div>
        <div class="col-md-8 col-sm-12">
        @if($id->getTable() =='rab')
        <form action="{{route('transaksiRAB',['id'=>$id->id])}}" method="get" enctype="multipart/form-data">
        @elseif($id->getTable()=='rabUnit')
        <form action="{{route('transaksiRABUnit',['id'=>$id->id])}}" method="get" enctype="multipart/form-data">
        @endif
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-sm-12 col-md-6 col-lg-6 mt-1 mr-n3" > <span style="font-size:small">Pilih Tanggal: </span> </label>
              <div class="input-group col-sm-12 col-md-6">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                  </div>
                </div>
                <input type="text" id="reportrange" class="form-control filter @error('filter') is-invalid @enderror" name="filter" value="{{ request('filter') }}" id="filter">
                <input type="hidden" name="start" id="mulai">
                <input type="hidden" name="end" id="akhir">
                <button type="submit" class="btn btn-primary btn-icon icon-right">Filter
                <i class="fa fa-filter"></i>
                </button>
              </div>
          </div>
        </div>
        </form>
        <script type="text/javascript">
          $(function() {
              moment.locale('id');
              var start = moment().subtract(29, 'days');
              var end = moment();
              function cb(start, end) {
                  $('#reportrange span').html(start.format('D M Y') + ' - ' + end.format('DD MMMM YYYY'));
                  $('#mulai').val(start);
                  $('#akhir').val(end);
              }
              $('#reportrange').daterangepicker({
                  startDate: start,
                  endDate: end,
                  ranges: {
                      'Hari Ini': [moment(), moment()],
                      'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                      '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                      '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                      'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                      'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                  }
              }, cb);
              });
          </script>
          {{-- end filter --}}
      </div>
      <table class="table table-sm table-striped" id="table">
        <thead>
          <tr>
            <th scope="col">Tanggal</th>
            <th scope="col">Kode Transaksi</th>
            <th scope="col">Uraian</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Sumber</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($transaksiKeluar as $transaksi)
          <tr>
            <td data-order="{{$transaksi->tanggal}}" >{{formatTanggal($transaksi->tanggal)}}</td>
            <td>
              @if($transaksi->rab)
            {{$transaksi->rab->kodeRAB}}
            @elseif($transaksi->rabUnit)
            {{$transaksi->rabUnit->kodeRAB}}
            @endif
            {{$transaksi->kategori}}
            </td>
            <td>{{$transaksi->uraian}} {{$transaksi->jumlah}} {{$transaksi->satuan}}</td>
            <td data-order="{{$transaksi->debet}}">Rp.{{number_format($transaksi->debet)}}</td>
            <td>{{$transaksi->sumber}}</td>
            <td>
              @if($transaksi->sumber != "Gudang")
              @if (cekGudang($transaksi->id) == "ada")
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
              {{-- data-akun="{{$transaksi->akun->id}}"  --}}
              data-awal="@if($transaksi->rab){{$transaksi->rab->kodeRAB}}@elseif($transaksi->rabUnit){{$transaksi->rabUnit->kodeRAB}}@endif" 
              >
              Sisa Barang</button>
              @endif
              @endif
              <button type="button" class="btn btn-sm btn-white text-danger border-danger" 
              data-toggle="modal" 
              data-target="#hapusTransaksi" 
              data-id="{{$transaksi->id}}" 
              data-uraian="{{$transaksi->uraian}}">
              <i class="fa fa-trash" aria-hidden="true" ></i> Hapus</button>
            </td>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="4" style="text-align: right; font-weight:bold;" class="text-primary"> <h5> Total: {{number_format($totalFilter)}}</h5></td>
          </tr>
        </tfoot>
      </table>
      {{-- {{$transaksiKeluar->links()}} --}}
    </div>
  </div>
 {{-- modal keGudang --}}
<div class="modal fade keGudang bd-example-modal-lg ml-5" id="keGudang" tabindex="-1" role="dialog" aria-labelledby="keGudangTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Transfer transaksi ke Gudang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" enctype="multipart/form-data" id="formTransfer" onchange="hitung()">
          @csrf
          <input type="hidden" class="form-control" name="transaksi_id" value="" id="id">
          <input type="hidden"  class="form-control " name="akun_id" value="" id="akun">
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal</label>
            <div class="col-sm-12 col-md-7">
              <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" value="" id="tanggal">
              @error('tanggal')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alokasi Awal</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('alokasiAwal') is-invalid @enderror" name="alokasiAwal" value="" id="alokasiAwal">
              @error('alokasiAwal')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Uraian</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('uraian') is-invalid @enderror" name="uraian" value="" id="uraian">
              @error('uraian')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jumlah Awal</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" readonly class="form-control @error('banyaknya') is-invalid @enderror" name="banyaknya" value="" id="banyaknya">
              @error('banyaknya')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Satuan</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" readonly class="form-control @error('satuan') is-invalid @enderror" name="satuan" value="" id="satuan">
              @error('satuan')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga Satuan</label>
            <div class="input-group col-sm-12 col-md-7">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  Rp
                </div>
              </div>
              <input type="text" readonly class="hargaGudang form-control @error('harga') is-invalid @enderror" name="harga" value="" min="0" max="100" id="harga">
              @error('harga')
              <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Total</label>
            <div class="input-group col-sm-12 col-md-7">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  Rp
                </div>
              </div>
              <input type="text" readonly class="totalGudang form-control @error('total') is-invalid @enderror" name="total" value="{{old('total')}} " min="0" max="100" id="total">
              @error('total')
              <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jumlah Terpakai</label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control @error('terpakai') is-invalid @enderror" max="" name="terpakai" value="" id="terpakai">
              @error('terpakai')
                <div class="invalid-feedback">{{$message}}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
            <div class="col-sm-12 col-md-7">
              <button class="btn btn-primary" type="submit">Transfer</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
          </div>
        </form>
        </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function () {
    $('#keGudang').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
    var tanggal = button.data('tanggal') 
    var uraian = button.data('uraian') 
    var satuan = button.data('satuan') 
    var jumlah = button.data('jumlah') 
    var harga = button.data('harga') 
    var total = button.data('total') 
    var akun = button.data('akun') 
    var kategori = button.data('kategori')
    var awal = button.data('awal')
    document.getElementById('formTransfer').action='/transferGudang/'+id;
    $('#id').val(id);
    $('#tanggal').val(tanggal);
    $('#akun').val(akun);
    $('#uraian').val(uraian);
    $('#banyaknya').val(jumlah);
    $('#terpakai').attr({"max":jumlah});
    $('#satuan').val(satuan);
    $('#harga').val(harga);
    $('#total').val(total);
    $('#alokasiAwal').val(awal);
    })
  });
  </script>
      <!-- Modal Hapus-->
      <div class="modal fade hapusTransaksi" id="hapusTransaksi" tabindex="-1" role="dialog" aria-labelledby="hapusTransaksiTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Hapus Transaksi</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="" method="post" id="formHapus">
                @method('delete')
                @csrf
                <p class="modal-text"></p>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Hapus!</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <script type="text/javascript">
        $(document).ready(function(){
          $('#hapusTransaksi').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var id = button.data('id') // Extract info from data-* attributes
          var uraian = button.data('uraian') 
          var modal = $(this)
          modal.find('.modal-text').text('Yakin ingin menghapus transaksi ' + uraian+' ?')
          document.getElementById('formHapus').action='/hapusTransaksiKeluar/'+id;
          })
        });
      </script>
@endsection
@section('script')
<script>
  function hitung(){
  var harga = parseInt((document.getElementById('harga').value).replace(/,/g, ''));
  var banyaknya = document.getElementById('banyaknya').value;
  var total = harga*banyaknya;
  $('#total').val(total);
  }

</script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script type="text/javascript" >
    $('#table').DataTable({
      "pageLength":     25,
      "language": {
        "decimal":        "",
        "emptyTable":     "Tidak ada data tersedia",
        "info":           "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        "infoEmpty":      "Menampilkan 0 sampai 0 dari 0 data",
        "infoFiltered":   "(difilter dari _MAX_ total data)",
        "infoPostFix":    "",
        "thousands":      ",",
        "lengthMenu":     "Menampilkan _MENU_ data",
        "loadingRecords": "Loading...",
        "processing":     "Processing...",
        "search":         "Cari:",
        "zeroRecords":    "Tidak ada data ditemukan",
        "paginate": {
            "first":      "Awal",
            "last":       "Akhir",
            "next":       "Selanjutnya",
            "previous":   "Sebelumnya"
        },
        }
    });
</script>
@endsection