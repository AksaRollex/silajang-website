<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SPP {{ $data->no_formulir }}</title>
</head>

<style>
    :root {
        font-size: 14px;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
        margin: 0px;
        padding: 0px;
        padding-bottom: 2rem;
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

    footer {
        position: fixed;
        bottom: 0px;
        left: 0px;
        right: 0px;
        text-align: center;
        border-top: 2px solid black;
    }

    .ttd {
        width: 150px;
        height: 100px;
        object-fit: contain;
    }
</style>

<body>
    <footer style="padding: 0.5rem; text-align: left">
        <span style="margin-right: 150px">No. Dok: FSOP.KJB-7.1.3</span>
        <span style="margin-right: 150px">No.Revisi: 2</span>
    </footer>

    <table style="margin-bottom: 2rem">
        <tr>
            <td>
                <img src="{{ public_path(App\Models\Setting::first()->kop_app) }}" width="80"
                    style="margin-left: 1.5rem">
            </td>
            <td style="text-align: center; width: 780px">
                <h3 style="margin: 0;">SURAT PERINTAH PENGUJIAN</h3>
                <h3 style="margin: 0;">
                    UPT LABORATORIUM LINGKUNGAN KABUPATEN JOMBANG</h3>
            </td>
            <td style="text-align: center;">
                <div style="transform: translateX(-2rem)">
                    <img src="{{ public_path(App\Models\Setting::first()->kop_sni) }}" width="150">
                    <div style="font-size: 12px;">Laboratorium Penguji</div>
                    <div style="font-size: 12px;">LP-1154-IDN</div>
                </div>
            </td>
        </tr>
    </table>

    <table style="margin-bottom: 1rem; width: auto">
        <tr>
            <td>No. Formulir</td>
            <td>:</td>
            <td>{{ $data->no_formulir }}</td>
        </tr>
        <tr>
            <td>Kode Sampel</td>
            <td>:</td>
            <td>{{ $data->kode }}</td>
        </tr>
    </table>

    <table class="main" cellpadding="6" cellspacing="0">
        <tr>
            <th style="text-align: center">No.</th>
            <th style="text-align: center">Analis yang Ditunjuk</th>
            <th style="text-align: center">Parameter</th>
            <th style="text-align: center">Metode</th>
            <th style="text-align: center">Satuan</th>
            <th style="text-align: center">Keterangan</th>
        </tr>

        @php
            $no = 1;
        @endphp
        @foreach ($analises as $i => $analis)
            @foreach ($analis->parameters as $j => $param)
                <tr>
                    @if ($j == 0)
                        <td style="text-align: center">{{ $no }}</td>
                        <td>{{ $analis->nama }}</td>
                        @php
                            $no++;
                        @endphp
                    @else
                        <td></td>
                        <td></td>
                    @endif
                    <td>{{ $param->nama }}</td>
                    <td style="text-align: center">{{ $param->metode }}</td>
                    <td style="text-align: center">{{ $param->satuan }}</td>
                    <td>{{ $param->keterangan_uji }}</td>
                </tr>
            @endforeach
        @endforeach
    </table>
    <div>Mohon dipedomani sebagai dasar pelaksanaan pengujian</div>

    <table style="margin-top: 2rem; page-break-inside: avoid">
        <tr>
            <td style="opacity: 0; width: 60%">-</td>
            <td style="width: 40%; text-align: center">
                <div>Jombang, {{ App\Helpers\AppHelper::tanggal_indo(date('Y-m-d')) }}</div>
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
