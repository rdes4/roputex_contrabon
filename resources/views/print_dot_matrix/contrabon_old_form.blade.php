<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Contrabon - {{$contrabon->nomor}}</title>
    <link rel="icon" href="{{asset('img/logo-roputex.png')}}" type="image/x-icon">
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
            /* padding-top: 100px; */
            /* padding-bottom: 100px; */
            background: #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* ===== AREA KERTAS ===== */
        .paper {
            background: white;
            width: 9.5in;
            height: 11in;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            padding: 0.25in;
            box-sizing: border-box;
            font-family: "Courier New", monospace;
            font-size: 13px;
            color: #000;
            overflow: hidden;
        }

        /* ===== TABEL UTAMA ===== */
        table.main {
            font-family: "myFont";
            /* font-family: "Consolas", "Courier New", monospace;; */
            table-layout: fixed;
            border-collapse: collapse;
        }

        table.main td, table.main th {
            border: 1px solid #000;
            padding: 1px 5px;
            vertical-align: middle;
            white-space: nowrap;
            border: none

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
                size:  9.5in 11in;
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
            <td colspan="43" height="" style="height: 0.75in"></td>
        </tr>
        <tr>
            <td colspan="43" height="15px"></td>
        </tr>
        <tr>
            <td colspan="22"></td>
            <td colspan="16">No. Rek : {{$contrabon->nomor_rekening}}</td>
        </tr>
        <tr>
            <td colspan="9" rowspan="2"></td>
            <td colspan="13" rowspan="2" style="font-size: 14px">{{strtoupper($contrabon->nama_customer)}}</td>
            <td colspan="16">Nama : {{$contrabon->nama_pemilik}}</td>
        </tr>
        <tr>
            <td colspan="16">Bank : {{$contrabon->bank}}</td>
        </tr>
        </tr>
        <tr>
            <td colspan="43" height="" style="height: 0.41in"></td>
        </tr>
        @php
            $no = 1;
            $min_row = 18;
            $total_faktur = 0;
        @endphp
        @foreach ($contrabon_faktur as $value)
        @php
            $pengurang = $value->jumlah_diskon != NULL ? $value->jumlah_diskon/100*$value->jumlah_faktur : $value->jumlah_retur;
            $retur_or_disc = $value->jumlah_diskon != NULL ? $value->jumlah_diskon : $value->jumlah_retur;
        @endphp
        <tr>
            <td colspan="1"  height="15px"></td>
            <td colspan="5" style="padding-left: 4px;">{{$value->nomor_faktur}}</td>
            <td colspan="5">{{ \Carbon\Carbon::parse($value->tgl_faktur)->format('d-m-Y') }}</td>
            <td colspan="4">{{$value->sales_order}}</td>
            <td colspan="5" style="text-align: right; padding-right: 8px">{{number_format($value->jumlah_faktur, 2, ',', '.')}}</td>
            <td colspan="6" style="text-align: right; padding-right: 9px">{{number_format($retur_or_disc, 2, ',', '.')}}</td>
            <td colspan="5" style="text-align: right; padding-right: 8px">{{number_format($value->jumlah_faktur-$pengurang, 2, ',', '.')}}</td>
        </tr>
        @php
            $total_faktur += $value->jumlah_faktur-$pengurang;
            $no++;
            $min_row--;
        @endphp
        @endforeach

        @for ($i = 0; $i < $min_row; $i++)
        <tr>
            <td colspan="9" height="15px"></td>
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
            <td colspan="26" style="font-weight: bold; text-align:right"></td>
            <td colspan="5" style="font-weight: bold; text-align:right; padding-top:9px">{{number_format($total_faktur)}}</td>
        </tr>

        <tr>
            <td colspan="43" height="" style="height: 0.6in"></td>
        </tr>
        <tr>
            <td colspan="11"></td>
            <td colspan="11" style="padding-left: 5px">{{ \Carbon\Carbon::parse($contrabon->tgl_jatuh_tempo)->translatedFormat('d F Y') }}</td>
            <td colspan="13" rowspan="2" style="padding-left: 10px">
                <br>
                <br>
                {{ \Carbon\Carbon::parse($contrabon->tgl_contrabon)->translatedFormat('d F Y') }}
            </td>
        </tr>
        <tr>
            <td colspan="7"></td>
            <td colspan="15">Sls : {{$contrabon->nama_sales}}</td>
        </tr>
        {{-- <tr>
            <td colspan="24"></td>
            <td colspan="13">{{ \Carbon\Carbon::parse($contrabon->tgl_contrabon)->translatedFormat('d F Y') }}</td>
        </tr> --}}

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
