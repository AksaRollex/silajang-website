<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Bukti Pembayaran {{ $data->no_formulir }}</title>
    <style>
        :root {
            font-size: 12px;
        }

        body {
            font-family: Times New Roman, serif;
            margin: 0px;
            padding: 0px;
        }

        .heading * {
            font-family: Arial, Helvetica, sans-serif;
        }

        table {
            width: 100%;
        }

        table.main td,
        table.main th {
            border: 2px solid black;
        }

        table.main th {
            text-align: center;
        }

        .checkbox {
            width: 1rem;
            height: 1rem;
            border: 1px solid black;
            display: inline-flex;
        }

        .checkbox.check {
            align-items: center;
            justify-content: center;
        }

        .italic * {
            font-style: italic;
        }

        .ttd {
            width: 150px;
            height: 100px;
            object-fit: contain;
        }

        ul.check {
            list-style: none;
        }

        ul.check li:before {
            content: '✓';
        }
    </style>
</head>

<body>
    <table class="heading" style="margin-bottom: 2rem">
        <tr>
            <td style="text-align: center;">
                <h3 style="margin: 0;">PEMERINTAH KABUPATEN JOMBANG</h3>
                <h3 style="margin: 0;">DINAS LINGKUNGAN HIDUP KABUPATEN JOMBANG</h3>
                <h3 style="margin: 0;">UPT LABORATORIUM LINGKUNGAN KABUPATEN JOMBANG</h3>
            </td>
        </tr>
    </table>

    <div style="height: 2px; background: #5c5c5c; margin: 2px"></div>
    <div style="height: 5px; background: #5c5c5c; margin: 2px"></div>

    <br><br>

    <h3 style="text-decoration: underline; text-align: center; margin: 0">TANDA BUKTI PEMBAYARAN</h3>

    <br>

    <table border="0" cellpadding="4" cellspacing="0">
        <tr>
            <td style="width: 30%">
                <div>Telah diterima dari</div>
            </td>
            <td style="width: 20px; text-align: center">:</td>
            <td>{{ $data->permohonan->user->nama }} / {{ $data->permohonan->user->detail->instansi }}</td>
        </tr>
        <tr>
            <td style="width: 30%">
                <div>Jumlah Uang</div>
            </td>
            <td style="width: 20px; text-align: center">:</td>
            <td>{{ App\Helpers\AppHelper::rupiah($data->payment->jumlah) }}</td>
        </tr>
        <tr>
            <td style="width: 30%">
                <div>Terbilang</div>
            </td>
            <td style="width: 20px; text-align: center">:</td>
            <td>{{ App\Helpers\AppHelper::AngkaToText($data->payment->jumlah) }} Rupiah</td>
        </tr>
        <tr>
            <td style="width: 30%">
                <div>Sebagai Pembayaran</div>
            </td>
            <td style="width: 20px; text-align: center">:</td>
            <td>Pengujian Laboratorium untuk Sampel dengan Kode {{ $data->kode }}</td>
        </tr>
    </table>

    <table style="margin-top: 2rem; page-break-inside: avoid">
        <tr>
            <td style="opacity: 0; width: 60%">-</td>
            <td style="width: 40%; text-align: center">
                <div>Jombang, {{ App\Helpers\AppHelper::tanggal_indo($data->payment->tanggal_bayar ?? date('Y-m-d')) }}
                </div>
                <div>{{ $ttd->jabatan }}</div>
                @if (@$ttd->tanda_tangan)
                    <img src="{{ public_path($ttd->tanda_tangan) }}" class="ttd">
                @else
                    <br><br><br><br><br><br>
                @endif
                <div>
                    <strong>{{ $ttd->nama }}</strong>
                </div>
                <div>NIP. {{ $ttd->nip }}</div>
            </td>
        </tr>
    </table>

</body>

</html>
