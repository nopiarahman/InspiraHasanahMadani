@extends('layouts.tema')
@section('menuDashboard', 'active')
@section('content')
    <div class="section-header">
        <h1>Dashboard</h1>
    </div>
    @if (auth()->user()->role == 'pelanggan')
        <div class="row ">
            <div class="col-6 col-md-6 col-sm-12">
                <div class="card profile-widget">
                    <div class="profile-widget-header">
                        <img style="width: 150px" alt="image"
                            @if (detailUser(auth()->user()->id)->poto != null) src="{{ Storage::url(detailUser(auth()->user()->id)->poto) }}"
              @else
              src="{{ asset('assets/img/avatar/avatar-1.png') }}" @endif
                            class="rounded-circle profile-widget-picture" st>
                        <div class="profile-widget-items">
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Blok</div>
                                <div class="profile-widget-item-value">
                                    @if ($dataKavling == null)
                                        Akad Dibatalkan
                                        @else{{ $dataKavling->blok }}
                                    @endif
                                </div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Jenis Kepemilikan</div>
                                <div class="profile-widget-item-value">{{ jenisKepemilikan($id->id) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-widget-description">
                        <div class="profile-widget-name ml-4 text-primary">
                            <h4> {{ $id->nama }} </h4>
                            <div class="text-muted d-inline font-weight-normal">
                            </div>
                        </div>
                        <table class="table table-hover ml-3">
                            <tbody>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td>{{ $id->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $id->email }}</td>
                                </tr>
                                <tr>
                                    <th>Tempat & Tanggal Lahir</th>
                                    <td>{{ $id->tempatLahir }} /
                                        {{ carbon\carbon::parse($id->tanggalLahir)->isoFormat('DD MMMM YYYY') }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>{{ $id->alamat }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>{{ $id->jenisKelamin }}</td>
                                </tr>
                                <tr>
                                    <th>Status Pernikahan</th>
                                    <td>{{ $id->statusPernikahan }}</td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan</th>
                                    <td>{{ $id->pekerjaan }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor Telepon</th>
                                    <td>{{ $id->nomorTelepon }}</td>
                                </tr>

                            </tbody>
                        </table>
                        {{-- Ujang maman is a superhero name in <b>Indonesia</b>, especially in my family. He is not a fictional character but an original hero in my family, a hero for his children and for his wife. So, I use the name as a user in this template. Not a tribute, I'm just bored with <b>'John Doe'</b>. --}}
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-sm-12 mt-5">
                <div class="card card-hero ">
                    <div class="card-header">
                        <div class="card-icon" style="color: rgb(192, 125, 0)">
                            <i class="fas fa-coins    "></i>
                        </div>
                        <div class="card-description">Status DP :
                            @if ($dataPembelian->sisaDp > 0)
                                Belum Lunas
                            @else
                                -
                            @endif
                        </div>

                        @if ($dataPembelian->sisaDp > 0)
                            <h4 style="font-size: x-large">Sisa DP : Rp. {{ number_format($dataPembelian->sisaDp) }}</h4>
                        @else
                            <h4>Lunas</h4>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        <div class="tickets-list">
                            <a href="#" class="ticket-item">
                                <div class="ticket-title">
                                    <h4>Riwayat Pembayaran</h4>
                                </div>
                                @forelse($dpPelanggan->take(2)->sortByDesc('no') as $dp)
                                    <div class="ticket-info">
                                        <div>Cicilan DP Ke: {{ $dp->urut }} Rp.{{ number_format($dp->jumlah) }}
                                        </div>
                                        <div class="bullet"></div>
                                        <div class="text-primary">
                                            {{ Carbon\Carbon::parse($dp->created_at)->diffForHumans() }}</div>
                                    </div>
                                @empty
                            </a>
                            <div class="ticket-info">
                                <div>Tidak Ada data</div>
                            </div>
    @endforelse
    <a href="{{ route('DPPelanggan') }}" class="ticket-item ticket-more">
        Lihat lengkap <i class="fas fa-chevron-right"></i>
    </a>
    </div>
    </div>
    </div>
    <div class="card card-hero ">
        <div class="card-header" style="background-image: linear-gradient(to bottom, #8fe700, #03a827);">
            <div class="card-icon" style="color:green">
                <i class="fas fa-money-bill-wave " aria-hidden="true"></i>
            </div>
            <div class="card-description">Status Cicilan :
                @if ($dataPembelian->sisaCicilan > 0)
                    Belum Lunas
                @else
                    -
                @endif
            </div>

            @if ($dataPembelian->sisaCicilan > 0)
                <h4 style="font-size: x-large">Sisa Kewajiban : Rp. {{ number_format($dataPembelian->sisaCicilan) }}</h4>
            @else
                Lunas
            @endif
        </div>
        <div class="card-body p-0">
            <div class="tickets-list">
                <a href="#" class="ticket-item">
                    <div class="ticket-title">
                        <h4>Riwayat Pembayaran</h4>
                    </div>
                    @forelse($cicilanPelanggan->take(2) as $cicilan)
                        <div class="ticket-info">
                            <div>Cicilan Ke: {{ $cicilan->urut }} Rp.{{ number_format($cicilan->jumlah) }}</div>
                            <div class="bullet"></div>
                            <div class="text-primary">{{ Carbon\Carbon::parse($cicilan->created_at)->diffForHumans() }}
                            </div>
                        </div>
                    @empty
                </a>
                <div class="ticket-info">
                    <div>Tidak Ada data</div>
                </div>
                @endforelse
                <a href="{{ route('unitPelanggan') }}" class="ticket-item ticket-more">
                    Lihat lengkap <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    @endif
    @if (auth()->user()->role == 'adminWeb')
        <div class="row">
            <div class="col">
                <div class="card profile-widget">
                    <div class="profile-widget-header">
                        <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}"
                            class="rounded-circle profile-widget-picture">
                        <div class="profile-widget-items">
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Alamat</div>
                                <div class="profile-widget-item-value">
                                    Jl. H.M. Kamil No 46 Rt 015 <br> Kel : Wijaya Pura
                                    Jambi 36139.
                                </div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Kontak</div>
                                <div class="profile-widget-item-value">Telp: (62/ 085266014432 <br>
                                    Email : muchdian.finwinner@gmail.com
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-widget-description">
                        <div class="profile-widget-name ml-4 text-primary">
                            <h4> Muchdian</h4>
                            <div class="text-muted d-inline font-weight-normal">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Pendidikan</h4>
                    </div>
                    <div class="card-body">
                        <ol>
                            <li>
                                <h6>Universitas Mercu Buana (Jakarta, Juli 2003)</h6>
                                <p>Bachelor of Civil Enginering, </p>
                            </li>
                            <li>
                                <h6>Akademi Teknologi Sapta Taruna (Jakarta, August 1999)</h6>
                                <p>Diploma 3 of Civil Enginering </p>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Training dan Seminar</h4>
                    </div>
                    <div class="card-body">
                        <ol>
                            <li>
                                Training leadership for 2 week’s in LM Patra (Jakarta,2002)
                            </li>
                            <li>
                                English Course di IEC the Conversation Program (Jakarta, 2003)
                            </li>
                            <li>
                                Program AUTO CAD 2000 2D&3D Course in LP3KT (Jakarta, 2004)
                            </li>
                            <li>
                                Program 3D Max R5 Program Course in LP3KT (Jakarta, 2004)
                            </li>
                            <li>
                                Training Program Pendalaman & Sertifikasi Personel Astra Friendly Company (Jambi, 2005)
                            </li>
                            <li>
                                Training & Seminar dengan Topic Pembahasan : Kemampuan dan Strategi Marketing dalam
                                Pencapaian
                                Target Penjualan oleh motivator Andre Wongso (Jakarta, 2005)
                            </li>
                            <li>
                                Training Topic Pembahasan : Measuring Customer Satisfaction, Marketing Plan, Business Plan
                                dan
                                Riset Pemasaran oleh Freddy Rangkuti & Associates best-selling (Jambi, 2006)
                            </li>
                            <li>
                                Training Pendalaman Bisnis Syariah di Asuransi dan Pembiayaan kendaraan di Selenggarakan
                                oleh
                                PT. Asuransi Astra dan PT. FIF (Jambi, 2007)
                            </li>
                            <li>
                                Training Persuasion and Selling skil with Neuro Linguistic Programming oleh Ronny f.
                                Ronodirdjo (Jakarta, 2008)
                            </li>
                            <li>
                                Mengikuti Sertifikasi Profesi REGISTERED FINANCIAL PLANNER (RFP) by FPSB bekerjasama
                                dengan
                                UNIVERSITAS INDONESIA (Jambi, May 2014)
                            </li>
                            <li>
                                Training dan Work Shop Akad Jual Beli pada Koperasi Syariah by Erwandi Tarmizi Associated
                                /ETA
                                . (Palembang , Oktober 2017)
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Skills</h4>
                    </div>
                    <div class="card-body">
                        <ol>
                            <li>
                                Strong leadership and interpersonal skills.
                            </li>
                            <li>
                                Negotiation skills.
                            </li>
                            <li>
                                Analytical skills including cost analysis and financial skills.
                            </li>
                            <li>
                                Fluently speaking and writing in English
                            </li>
                            <li>
                                Computer literate (Win 98/2007/XP, Microsoft Office XP programs ( Word, Excel. Power Point,
                                Corel Draw) MsOutlook, SAP, Lotus Note/E-mail user and Inte, SAP, Lotus Note/E-mail user and
                                Internet tools).

                            </li>

                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Professional Experience</h4>
                    </div>
                    <div class="card-body">
                        <ol>
                            <li>
                                <strong> PT. INSPIRA HASANAH ,MADANI</strong> Direktur Utama 2020- Now
                            </li>
                            <li>
                                <strong>
                                    PT. TIFA TOUR
                                </strong>
                                Kepala Perwakilan (Jambi, 2019- 2020)
                            </li>
                            <li>
                                <strong>ELANG PROPERTY
                                </strong>
                                Kepala Perwakilan (Jambi, 2019-2020)
                            </li>
                            <li>
                                <strong>
                                    PT. SANABIL UMROH
                                </strong>
                                Kepala Perwakilan (Jambi, 2018- 2019)
                            </li>
                            <li>
                                <strong>
                                    PT. MTRA INSPIRA MADANI
                                </strong>
                                Directur Pemasaran (Jambi, 2017- 2019)
                            </li>
                            <li>
                                <strong>
                                    PT. PRUDENTIAL LIFE ASSURANCE
                                </strong>
                                Agency Directur (Jambi, January 2011 –2017)
                                <ul>
                                    <li>
                                        Sebagai Financial Konsultan yang Memasarkan Produk Asuransi Unit Link secara
                                        langsung ke
                                        Customer atau Membuka Pasar Baru Melalui Jalur Jaringan team Agent.
                                    </li>
                                    <li>
                                        Memanaged & Supervisi agent (Recruitment, Produksi dan Report)
                                    </li>
                                    <li>
                                        Sebagai Team Trainer di Agency
                                    </li>
                                    <li>
                                        PIC Kantor Agency di Kota Muara Bulian
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <strong>
                                    PT. BIODIESEL JAMBI (PMA From INDIA, Group KS Oils Palm & Oil Plantation)
                                </strong><br>
                                Logistik Manager (Jambi, Oktober 2009 –2011)
                                <ul>
                                    <li>
                                        Reported to Direktur Operasional
                                    </li>
                                    <li>
                                        Managed dan Supervise Logistik Divisi.
                                    </li>
                                    <li>
                                        Memenuhi dan Membeli kebutuhan/ Permintaan Kantor dan Kebun.
                                    </li>
                                    <li>
                                        Menentukan Supplier dengan mempertimbangkan harga yang ekonomis & efisien.
                                    </li>
                                    <li>
                                        Melakukan Kontrol pembelian hingga sampai pengiriman ke office/gudang.
                                    </li>
                                    <li>
                                        Bertanggung jawab terhadap kebutuhan Gudang di kebun dan Membuat Repot Data stock
                                        bulanan
                                        berdasarkan hasil stock opname Div. Logistik perbulan.
                                    </li>
                                </ul>

                                General Affair Manager (Jambi, Juni 2009- Oktober 2009)
                                <ul>
                                    <li>
                                        Reported to Direktur Umum
                                    </li>
                                    <li>
                                        Managed dan Supervise GA Divisi.
                                    </li>
                                    <li>
                                        Kontrol Kebutuhan Office dan Kebun (Maintenance Kendaraan, Alat Berat,Genset,
                                        gedung,
                                        Kebutuhan Atk, Perijinan & Legalitas Perusahaan, Asuransi Aset, dll)
                                    </li>
                                    <li>
                                        Membuat Repot Aset Perbulan dan Membuat Budget GA Divisi
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <strong>
                                    PT. ASURANSI ASTRA / GARDA OTO (Group PT. Astra International, Tbk)
                                </strong>
                                Senior Sales Officer (Jambi, 2008 – 2009)
                                <br>
                                Branch Promotion & Sales Officer ( Jambi, 2005 – 2008)
                                <ul>
                                    <li>
                                        Reporting to Branch Manager.
                                    </li>
                                    <li>
                                        Membuat Program/Kegiatan Promosi Asuransi Garda Oto di Cabang.
                                    </li>
                                    <li>
                                        Memasarkan Produk Asuransi Garda Oto secara langsung ke Customer atau Jalur
                                        Distribusi
                                        Penjualan Garda Oto ( Dealer, Banking, Leasing ).
                                    </li>
                                    <li>
                                        Memanaged & Supervisi Reguler / Referal agent (Recruitment, Produksi dan Report)
                                    </li>
                                    <li>
                                        Bertanggung jawab terhadap target produksi dari customer Retail di cabang ( Walk- in
                                        Customer,
                                        Agent, Amway, Dealer, Bangking, GO Coy).
                                    </li>
                                    <li>
                                        Membuat Report untuk Bahan Planning Cycle for Branch Review per kuartal
                                    </li>
                                    <li>
                                        Membuat mapping dan market share dari kondisi pasar untuk report cabang.
                                    </li>
                                    <li>
                                        Membuat budget dasar tahunan untuk program marketing
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <strong>
                                    PT. L’ORÉAL INDONESIA (International Company L’ORÉAL Group )
                                </strong>
                                Merchandising Officer (Jakarta, 2002 – 2005) <br>
                                Built and developed Merchandising Department. Managed purchasing and logistics of Marketing
                                and
                                Sales Equipment. Maintained and managed key customer and supplier relationship. Key
                                Contributions/Projects:
                                <ul>
                                    <li>
                                        Reporting to Senior DBU Manager PT. Loreal Indonesia
                                    </li>
                                    <li>
                                        Exspansi Jalur Distribusi ke Hypermarket Supermarket dan Dept. store
                                    </li>
                                    <li>
                                        Membuat Planogram dan Manajemen Perlertakan/Display Barang Jual.
                                    </li>
                                    <li>
                                        Instructur Training Merchandising.
                                    </li>
                                    <li>
                                        Supervisi Supplier dalam hal design Counter dan Technical Drawing.
                                    </li>
                                    <li>
                                        Menegosiasikan pembelian ke Supplier untuk mendapatkan harga terbaik.
                                    </li>
                                    <li>
                                        Mengawasi kualitas barang yg sedang diproduksi oleh Supplier.
                                    </li>
                                    <li>
                                        Mengatur/Mengurusi seluruh Counter dan event promosi.
                                    </li>
                                    <li>
                                        Mengajukan & Menegosiasikan Area dan Design Counter kepada Pihak Store.
                                    </li>
                                    <li>
                                        Membuat budget dasar untuk rencana marketing
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <strong>
                                    PT. AASCO Consultant Jambi
                                </strong>
                                Staff Ahli Tehnik (Jambi, 2000 – 2002) (Kontrak)
                                <ul>
                                    <li>
                                        Team Leader Proyek Perencanaan
                                    </li>
                                    <li>
                                        Utusan Perusahaan dalam Tender Proyek
                                    </li>
                                    <li>
                                        Estimator Project
                                    </li>
                                    <li>
                                        Inspector
                                    </li>
                                    <li>
                                        Mengurusi Termyn Project untuk Perusahaan
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <strong>
                                    PT. LENTERA CIPTA NUSA . ( Jakarta, 1999-2000)
                                </strong>
                                Supervisor Engineering ( Kontrak 1 tahun)
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Track Of Record</h4>
                    </div>
                    <div class="card-body">
                        <ol>
                            <li>
                                <strong>
                                    PT.PRUDENTIAL LIFE ASSURANCE
                                </strong>
                                <ul>
                                    <li>
                                        3 tahun mencapai Karir Agency Manager
                                        <ul>
                                            <li>
                                                2012 Unit Manager
                                            </li>
                                            <li>
                                                2013 Senior Unit Manager
                                            </li>
                                            <li>
                                                2014 Agency Manager.
                                            </li>
                                            <li>
                                                Tahun 2012 mencapai prestasi TOP NO 1 Unit Manager Di Agency National dan
                                                TOP 500 leader di Prudential Life ke KL Malaysia
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        Tahun 2013 TOP No 2 Senior Unit Manager Di Agency National
                                    </li>
                                    <li>
                                        Tahun 2014 dipercaya menjadi Chairman di Agency ( Kepala 66 Leader dan 300 agent )
                                    </li>
                                    <li>
                                        Tahun 2015 Membuka kantor perwakilan Agency di Muara Bulian.
                                    </li>
                                    <li>
                                        Tahun 2016 dipercaya sebagai PIC Syariah di Agency Finwinner.
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <strong>
                                    PT. BIODIESEL JAMBI
                                </strong>
                                <ul>
                                    <li>
                                        Joint 4 bulan dimutasikan/dipercaya sebagai Logistik Manager.
                                    </li>
                                    <li>
                                        Efesiensi Pembelian Material Agronomis dan Tehnik Mencapai 20 % dari Pembelian
                                        sebelumnya
                                        sehingga Beban Project yang ditanggung Perusahaan makin kecil.
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <strong>
                                    PT. ASURANSI ASTRA / GARDA OTO
                                </strong>
                                <ul>
                                    <li>
                                        Tahun 2007 Pemenang 10 besar SO Contest (Sales Countest) PT. Asuransi Astra Buana
                                        Seluruh
                                        Indonesia.
                                    </li>
                                    <li>
                                        Tahun 2007 menjadi pemenang Best of the Best STAR PROGRAM PT. Asuransi Astra Buana
                                        (Award
                                        karyawan terbaik seluruh indonesia)
                                    </li>
                                    <li>
                                        Tahun 2008 menjadi pemenang The Best Sales Officer PT. Asuransi Astra Buana
                                    </li>
                                    <li>
                                        Tahun 2008 menjadi pemenang Best of the Best STAR PROGRAM PT. Asuransi Astra Buana
                                        (Award
                                        karyawan terbaik seluruh indonesia)
                                    </li>
                                    <li>
                                        Tahun 2006 mengirim award 1 contestan sales dealer Jambi masuk nominasi 5 besar
                                        contes
                                        sales dealer seluruh Indonesia.
                                    </li>
                                    <li>
                                        Tahun 2008 mengirim contestan award sales delaer Jambi 2 orang menjadi nominasi 3
                                        besar
                                        contes sales dealer seluruh Indonesia.
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <strong>
                                    PT. L’ORÉAL INDONESI A
                                </strong>
                                <ul>
                                    <li>
                                        Tahun 2003 Dipercaya handle 2 brand Loreal dan Maybelline di Dept. Store departement
                                    </li>
                                    <li>
                                        Tahun 2004 dalam 1 tahun meyelesaikan 55 project Counter Loreal & Maybelline
                                    </li>
                                    <li>
                                        Dari event promosi yang diadakan tahun 2004 pencapaian Achievment penjualan
                                        mencapai 150 % dari target tahunan.
                                    </li>
                                </ul>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (auth()->user()->role == 'admin' || auth()->user()->role == 'projectmanager' || auth()->user()->role == 'adminGudang' || auth()->user()->role == 'marketing' || auth()->user()->role == 'komisaris')
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <a href="{{ route('cashFlow') }}">
                    <div class="card card-statistic-2">
                        <div class="card-chart">
                            <div class="chartjs-size-monitor"
                                style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                <div class="chartjs-size-monitor-expand"
                                    style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink"
                                    style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                </div>
                            </div>
                            {{-- <canvas id="sales-chart" height="63" width="269" style="display: block; height: 71px; width: 300px;" class="chartjs-render-monitor"></canvas> --}}
                        </div>
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Kas Besar</h4>
                            </div>
                            <div class="card-body">
                                <h4>
                                    Rp. {{ number_format(saldoTerakhir()) }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <a href="{{ route('kasPendaftaranMasuk') }}">
                    <div class="card card-statistic-2">
                        <div class="card-chart">
                            <div class="chartjs-size-monitor"
                                style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                <div class="chartjs-size-monitor-expand"
                                    style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink"
                                    style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                </div>
                            </div>
                            {{-- <canvas id="balance-chart" height="63" width="269" style="display: block; height: 71px; width: 300px;" class="chartjs-render-monitor"></canvas> --}}
                        </div>
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Kas Pendaftaran</h4>
                            </div>
                            <div class="card-body">
                                <h4>
                                    Rp. {{ number_format(saldoTerakhirKasPendaftaran()) }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <a href="{{ route('pettyCash') }}">
                    <div class="card card-statistic-2">
                        <div class="card-chart">
                            <div class="chartjs-size-monitor"
                                style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                <div class="chartjs-size-monitor-expand"
                                    style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink"
                                    style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                    <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                </div>
                            </div>
                            {{-- <canvas id="sales-chart" height="63" width="269" style="display: block; height: 71px; width: 300px;" class="chartjs-render-monitor"></canvas> --}}
                        </div>
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-donate    "></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Kas Kecil</h4>
                            </div>
                            <div class="card-body">
                                <h4>
                                    Rp. {{ number_format(saldoTerakhirPettyCash()) }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Kas Besar</h4>
                        <div class="card-header-action">
                            {{-- <div class="btn-group">
              <a href="#" class="btn btn-primary">Week</a>
              <a href="#" class="btn">Month</a>
            </div> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div style="height: 400px">
                            {!! $chartKasBesar->container() !!}
                        </div>
                    </div>
                </div>
            </div>
    @endif
    <div class="col-lg-4 col-md-12 col-12 col-sm-12">
        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'projectmanager')
            <div class="card">
                <div class="card-header">
                    <h4>Quick Link</h4>
                </div>
                <div class="card-body">
                    <a href="{{ route('transaksiKeluar') }}" class="btn btn-icon icon-left btn-primary col-12 my-1"><i
                            class="fas fa-money-bill"></i> Tambah Transaksi Keluar</a>
                    <a href="{{ route('kasPendaftaranMasuk') }}"
                        class="btn btn-icon icon-left btn-primary col-12 my-1"><i class="fas fa-money-bill"></i> Kas
                        Pendaftaran</a>
                    <a href="{{ route('pettyCash') }}" class="btn btn-icon icon-left btn-primary col-12 my-1"><i
                            class="fas fa-piggy-bank    "></i> Kas Kecil</a>
                </div>
            </div>
        @endif
        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'projectmanager' || auth()->user()->role == 'komisaris')
            <div class="card">
                <div class="card-header">
                    <h4>Status Proyek</h4>
                </div>
                <div class="card-body justify-content-center mb-3">
                    <span>Jumlah Unit:</span>
                    <h4 class="text-large text-primary"> {{ $kavling->count() }} Unit</h4>
                    <span>Jumlah Unit Terjual:</span>
                    <h4 class="text-primary"> {{ $kavling->where('pelanggan_id', '!=', 0)->count() }} Unit</h4>
                </div>
            </div>
        @endif
    </div>
    </div>
    @if (auth()->user()->role == 'admin' || auth()->user()->role == 'projectmanager' || auth()->user()->role == 'komisaris')
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Omset</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-12">
                                {!! $chartPendapatan->container() !!}
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <h4 class="text-primary mb-2">Rincian Omset</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="extra-radius">
                                            <div class="card">
                                                <div class="card-header"
                                                    style="background-image: linear-gradient(to bottom, #8fe700, #03a827);">
                                                    <h4 style="color: white">Rp. {{ number_format($pendapatanKavling) }}
                                                    </h4>
                                                    <span style="color: white">Total Kavling</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-n2">
                                    <div class="col-12">
                                        <div class="extra-radius">
                                            <div class="card">
                                                <div class="card-header"
                                                    style="background-image: linear-gradient(to bottom, #ffd208, #ee9c03);">
                                                    <h4 style="color: white">Rp. {{ number_format($pendapatanRumah) }}
                                                    </h4>
                                                    <span style="color: white">Total Rumah</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-n2">
                                    <div class="col-12">
                                        <div class="extra-radius">
                                            <div class="card">
                                                <div class="card-header"
                                                    style="background-image: linear-gradient(to bottom, #ff6b08, #ad342e);">
                                                    <h4 style="color: white">Rp. {{ number_format($kelebihanTanah) }}
                                                    </h4>
                                                    <span style="color: white">Total Kelebihan Tanah</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-n2">
                                    <div class="col-12">
                                        <div class="extra-radius">
                                            <div class="card card-hero">
                                                <div class="card-header"
                                                    style="background-image: linear-gradient(to bottom, #08ceff, #037cee);">
                                                    <div class="card-icon" style="color: rgb(2, 49, 63)">
                                                        <i class="fas fa-money-bill-wave " style="font-size: 6rem"></i>
                                                    </div>
                                                    <h4 style="font-size:2rem">Rp. {{ number_format($totalPendapatan) }}
                                                    </h4>
                                                    <div class="card-description">Total Omset</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Presentase Proyek</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                {!! $chartDPKavling->container() !!}
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                {!! $chartDPRumah->container() !!}
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                {!! $chartDPKios->container() !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12" style="text-align: center">
                                <p class="text-primary font-weight-bold">DP Kavling Terbayar:
                                    Rp.{{ number_format($totalDpTerbayar) }}</p>
                                <p class="mt-n3 font-weight-bold" style="color: #ffa426">Sisa DP:
                                    Rp.{{ number_format($sisaDp) }}</p>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12" style="text-align: center">
                                <p class="text-primary font-weight-bold">DP Rumah Terbayar:
                                    Rp.{{ number_format($totalDpRumahTerbayar) }}</p>
                                <p class="mt-n3 font-weight-bold" style="color: #ffa426">Sisa DP:
                                    Rp.{{ number_format($sisaDpRumah) }}</p>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12" style="text-align: center">
                                <p class="text-primary font-weight-bold">DP Kios Terbayar:
                                    Rp.{{ number_format($totalDpKiosTerbayar) }}</p>
                                <p class="mt-n3 font-weight-bold" style="color: #ffa426">Sisa DP:
                                    Rp.{{ number_format($sisaDpKios) }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                {!! $chartCicilanKavling->container() !!}
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                {!! $chartCicilanRumah->container() !!}
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                {!! $chartCicilanKios->container() !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12" style="text-align: center">
                                <p class="text-primary font-weight-bold">Cicilan Kavling Terbayar:
                                    Rp.{{ number_format($totalCicilanTerbayar) }}</p>
                                <p class="mt-n3 font-weight-bold" style="color: #ffa426">Sisa Cicilan:
                                    Rp.{{ number_format($sisaCicilan) }}</p>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12" style="text-align: center">
                                <p class="text-primary font-weight-bold">Cicilan Rumah Terbayar:
                                    Rp.{{ number_format($totalCicilanRumahTerbayar) }}</p>
                                <p class="mt-n3 font-weight-bold" style="color: #ffa426">Sisa Cicilan:
                                    Rp.{{ number_format($sisaCicilanRumah) }}</p>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12" style="text-align: center">
                                <p class="text-primary font-weight-bold">Cicilan Kios Terbayar:
                                    Rp.{{ number_format($totalCicilanKiosTerbayar) }}</p>
                                <p class="mt-n3 font-weight-bold" style="color: #ffa426">Sisa Cicilan:
                                    Rp.{{ number_format($sisaCicilanKios) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('script')
    {!! $chartKasBesar->script() !!}
    {!! $chartDPKavling->script() !!}
    {!! $chartDPRumah->script() !!}
    {!! $chartDPKios->script() !!}
    {!! $chartCicilanKavling->script() !!}
    {!! $chartCicilanRumah->script() !!}
    {!! $chartCicilanKios->script() !!}
    {!! $chartPendapatan->script() !!}
    {{-- <script src="{{asset('assets/js/index.js')}}"></script> --}}
@endsection
