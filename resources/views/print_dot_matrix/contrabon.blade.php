<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{asset('img/logo-roputex.png')}}" type="image/x-icon">
    <title>Contrabon - {{$contrabon->nomor}}</title>
    <style>
        /* ===== LATAR ABU DI LUAR KERTAS ===== */
        @font-face {
            font-family: 'MyFont';
            font-style: normal;
            font-weight: 400;
            src: url('../../../../fonts/print.TTF') format('truetype');
        }

        html, body {
            /* height: 100%; */
            /* margin: 0; */
            background: #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* ===== AREA KERTAS ===== */
        .paper {
            background: white;
            width: 9.5in;
            /* height: 11in; */
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            padding: 0.25in;
            box-sizing: border-box;
            font-family: "Courier New", monospace;
            font-size: 10pt;
            color: #000;
            overflow: hidden;
            padding-right: 50px;
            padding-top: 18px;
        }

        /* ===== TABEL UTAMA ===== */
        table.main {
            /* font-family: "myFont"; */
            font-family: "Consolas", "Courier New", monospace;;
            table-layout: fixed;
            border-collapse: collapse;
        }

        table.main td, table.main th {
            border: 1px solid #000;
            padding: 1px 5px;
            vertical-align: middle;
            /* border: none */
        }

        .border {
            border: 1px solid !important;
        }

        /* Tombol print hanya di layar */
        .no-print {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 999;
        }

        @media print {
            html, body {
                background: none;
                margin: 0;
                display: block;
            }

            .paper {
                box-shadow: none;
                width: 9.5in;
                height: 11in;
                page-break-inside: avoid;
            }

            @page {
                /* size: 9.5in 5.5in; */
                margin: 0in;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<button class="no-print" onclick="window.print()">🖨️ Cetak</button>

<div class="paper">
    {{-- TOTAL TD = 42 --}}

    <table class="main" style="width:100%">

        <tr>
            <td colspan="3" rowspan="3" style="text-align: center; border: none">
                 <img style="max-height: 50px" src="{{asset('img/logo-roputex.jpg')}}">
            </td>
            <td rowspan="3" colspan="13" style="border: none">
               <span style="font-size: 16px">PT ROONEY PUTRA TEXTINDO</span>

            </td>
            <td colspan="4">Nomor</td>
           <td colspan="9">: {{$contrabon->nomor}}</td>
            <td colspan="5">Sales</td>
            <td colspan="9">: {{$contrabon->nama_sales}}</td>

        </tr>


        <tr>
            <td colspan="4">Tanggal</td>
            <td colspan="9">: {{ \Carbon\Carbon::parse($contrabon->tgl_contrabon)->translatedFormat('d F Y') }}</td>
            <td colspan="5">Jth. Tempo</td>
            <td colspan="9">: {{ \Carbon\Carbon::parse($contrabon->tgl_jatuh_tempo)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td colspan="4">Kepada</td>
            <td colspan="23">: {{$contrabon->nama_customer}}</td>
        </tr>

        <tr>
            <td colspan="43" height="5px" style="border: none"></td>
        </tr>
        <tr>
            <td colspan="43" height="20px" style="border-bottom: none; text-align: center; font-weight: bold">TANDA TERIMA</td>
        </tr>

        <tr>
            <td colspan="2">No.</td>
            <td colspan="7" style="text-align: center">Nomor Faktur</td>
            <td colspan="7" style="text-align: center">Tanggal Faktur</td>
            <td colspan="5" style="text-align: center">SO</td>
            <td colspan="7" style="text-align: center">Jumlah</td>
            <td colspan="7" style="text-align: center">Retur/Diskon</td>
            <td colspan="8" style="text-align: center">Total</td>
        </tr>

        @php
            $no = 1;
            $min_row = 17;
            $total_faktur = 0;
        @endphp
        @foreach ($contrabon_faktur as $value)
        @php
            $pengurang = $value->jumlah_diskon != NULL ? $value->jumlah_diskon/100*$value->jumlah_faktur : $value->jumlah_retur;
            $retur_or_disc = $value->jumlah_retur != NULL && $value->jumlah_retur > 0 ? number_format($value->jumlah_retur, 0, ',', '.') : '';
        @endphp
        <tr>
            <td colspan="2">{{$no}}</td>
            <td colspan="7">{{$value->nomor_faktur}}</td>
            <td colspan="7">{{ \Carbon\Carbon::parse($value->tgl_faktur)->format('d-m-Y') }}</td>
            <td colspan="5">{{$value->sales_order}}</td>
            <td colspan="7" style="text-align: right">{{number_format($value->jumlah_faktur, 0)}}</td>
            <td colspan="7" style="text-align: right">{{$retur_or_disc}}</td>
            <td colspan="8" style="text-align: right">{{number_format($value->jumlah_faktur-$pengurang, 0)}}</td>
        </tr>
        @php
            $total_faktur += $value->jumlah_faktur-$pengurang;
            $no++;
            $min_row--;
        @endphp
        @endforeach

        @for ($i = 0; $i < $min_row; $i++)
        <tr>
            <td colspan="2">{{$no}}</td>
            <td colspan="7"></td>
            <td colspan="7"></td>
            <td colspan="5"></td>
            <td colspan="7" style="text-align: right"></td>
            <td colspan="7" style="text-align: right"></td>
            <td colspan="8" style="text-align: right"></td>
        </tr>
         @php
            $no++;
        @endphp
        @endfor

        <tr>
            <td colspan="35" style="font-weight: bold; text-align:right">TOTAL</td>
            <td colspan="8" style="font-weight: bold; text-align:right">{{number_format($total_faktur, 2)}}</td>
        </tr>

        <tr>
            <td colspan="43" height="5px" style="border: none"></td>
        </tr>

        <tr>
            <td colspan="19" style="vertical-align: top; text-align: justify;">
                Catatan :
            </td>
            <td colspan="14" style="border-right: none; border-bottom:none;"></td>
            <td colspan="10" style="border-left: none; border-bottom:none; text-align:center">Jakarta, {{ \Carbon\Carbon::parse($contrabon->tgl_contrabon)->translatedFormat('d F Y') }}</td>
        </tr>

        <tr>
            <td colspan="2"  rowspan="3" style="vertical-align: top">1. </td>
            <td colspan="17" rowspan="3">
                 Pembayaran dianggap LUNAS secara sah setelah Giro atau Cek diterima dan berhasil dicairkan oleh pihak bank.
            </td>
            <td colspan="10" style="text-align: center; border-top: none;;border-bottom:none; border-right: none">
                Diserahkan oleh,
            </td>
            <td colspan="4" style="border:none;"></td>
            <td colspan="10" style="text-align: center; border-top: none;;border-bottom:none; border-left: none">
                Yang menerima,
            </td>
        </tr>

        <tr>
            <td colspan="10" height="12px" style="text-align: center; border-top: none; border-right: none; border-bottom: none"></td>
            <td colspan="4" style="border:none;"></td>
            <td colspan="10" style="text-align: center-top; border-top: none; border-bottom: none; border-left: none;"></td>
        </tr>
        <tr>
            <td colspan="10" height="12px" style="text-align: center; border-top: none; border-right: none; border-bottom: none"></td>
            <td colspan="4" style="border:none;"></td>
            <td colspan="10" style="text-align: center-top; border-top: none; border-bottom: none; border-left: none;"></td>
        </tr>
        <tr>
            <td colspan="2"  rowspan="3" style="vertical-align: top">2. </td>
            <td colspan="17" rowspan="3" style="vertical-align: top">
                Transfer ke :
                <br>
                {{$contrabon->bank}} - {{$contrabon->nomor_rekening}}
                <br>
                A.N. {{$contrabon->nama_pemilik}}
            </td>
            <td colspan="10" height="12px" style="text-align: center; border-top: none; border-right: none; border-bottom: none"></td>
            <td colspan="4" style="border:none;"></td>
            <td colspan="10" style="text-align: center-top; border-top: none; border-bottom: none; border-left: none;"></td>
        </tr>
        <tr>
            <td colspan="10" height="12px" style="text-align: center; border-top: none; border-right: none; border-bottom: none"></td>
            <td colspan="4" style="border:none;"></td>
            <td colspan="10" style="text-align: center-top; border-top: none; border-bottom: none; border-left: none;"></td>
        </tr>
        <tr>
            <td colspan="10" height="12px" style="text-align: center; border-top: none; border-right: none; border-left: none">
                (_____________________)
                <br>
                Bagian Penagih
            </td>
            <td colspan="4" style="border-top: none; border-right: none; border-left: none;"></td>
            <td colspan="10" style="text-align: center; border-top: none; border-left: none;">
                (_____________________)
                <br>
                Pelanggan
            </td>
        </tr>

        <tr>
            <td height="10px" style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
            <td style="border: none"></td>
        </tr>
    </table>
</div>

</body>
</html>
