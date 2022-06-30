<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!-- saved from url=(0068)https://s3.pdfconvertonline.com/convert/p3r68-cdx67/mnsg3-aeeqj.html -->
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <title></title>
    <style type="text/css">
        body,
        div,
        table,
        tbody,
        tr,
        th,
        td,
        p {
            font-family: "Calibri";
            font-size: x-small
        }

        table {
            width: 100%;
        }
    </style>

</head>

<body>
    <table cellspacing="0">
        <tbody>
            <tr>
                <td rowspan="4" valign="top" align="center"><br><img
                        src="{{ public_path(Storage::url($proyek->logoPT)) }}" alt="" width="80px"></td>
                <td align="left" colspan="3"><b>
                        <font size="4">{{ $proyek->namaPT }}
                    </b></td>
            </tr>
            <tr>
                <td colspan="2">{{ $proyek->alamatPT }}</td>
                <td>Nomor Faktur: @if (jenisKepemilikan($pembelian->pelanggan_id) == 'Kavling')
                        CK
                    @else
                        CB
                    @endif
                    {{ romawi(Carbon\Carbon::parse($id->tanggal)->isoFormat('MM')) }}/{{ $id->ke }}</td>
            </tr>
            <tr>
                <td colspan="2">Telp: {{ $proyek->telpPT }}</td>
                <td>Tanggal: {{ formatTanggal($id->tanggal) }}</td>
            </tr>
            <tr>
                <td colspan="2">Email: {{ $proyek->emailPT }}</td>
                <td>Kode Pelanggan: C{{ $pembelian->kavling->blok }}</td>
            </tr>
            <tr>
                <td colspan="4" align="center" style="padding:10px; border-top:1px solid;"><b>
                        <font size="5" color="#00B050">KWITANSI
                    </b></td>
            </tr>
            <tr>
                <td>Telah Diterima Dari</td>
                <td>: {{ $pembelian->pelanggan->nama }}</td>
                <td colspan="2" style="border: 1px solid #000000;" rowspan="2" align="center" valign="middle">
                    <b><i>

                            {{ terbilang($id->jumlah) }}
                            Rupiah
                        </i></b>
                </td>
            </tr>
            <tr>
                <td>Sejumlah Uang</td>
                <td>: Rp. {{ number_format($id->jumlah) }}</td>
            </tr>
            <tr>
                <td style="padding-top: 15px; padding-right:10px" align="right"><b>No</b></td>
                <td style="padding-top: 15px"><b>Keterangan</b></td>
                <td style="padding-top: 15px" colspan="2"><b>Jumlah</b></td>
            </tr>
            <tr>
                <td align="right" style=" padding-right:10px"">1</td>
                <td>Pembayaran Tambahan {{ $id->tambahan->keterangan }}</td>
                <td colspan="2">Rp. {{ number_format($id->jumlah) }}</td>
            </tr>
            <tr>
                <td colspan="4" style="padding:5px 0px 5px 0px"><b>
                        <font size="4" color="#6C757D">Metode Pembayaran: <span style="color: green">
                                @if ($id->sumber == 'Cash' || $id->sumber == 'cash')
                                    TUNAI
                                @else
                                    TRANSFER
                                @endif
                            </span>
                    </b></td>
            </tr>
            <tr>
                <td>Total Hutang</td>
                <td>: Rp {{ number_format($id->tambahan->total) }}</td>
                <td rowspan="5" colspan="2" align="center"> <img
                        src="{{ public_path(Storage::url($proyek->logoPT)) }}" id="stempel" width="100px"></td>
            </tr>
            <td>Sisa Hutang</td>
            <td>: <span
                    class="text-warning">Rp.{{ number_format($id->tambahan->total - hitungDetailTambahan($id->tambahan->id)) }}
            </td>
            </tr>
            <tr>
                <td>Status</td>
                <td>:
                    @if ($id->tambahan->total - hitungDetailTambahan($id->tambahan->id) <= 0)
                        <span class="text-primary">Lunas </span>
                    @else
                        <span class="text-warning">Belum Lunas </span>
                    @endif
                </td>
            </tr>
            <tr>
                <td align="center" colspan="4" valign="bottom" style="height: 10px">Kwitansi digital ini sah tanpa
                    tanda tangan</td>
            </tr>
        </tbody>
    </table>

    <br clear="left">
    <!-- ************************************************************************** -->



</body>

</html>
