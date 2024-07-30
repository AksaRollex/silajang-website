<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rangkaian Pengamanan Sampel {{ $data->no_formulir }}</title>
</head>

<style>
    :root {
        font-size: 16px;
    }

    body {
        font-family: Times New Roman, serif;
        margin: 0px;
        padding: 0px;
        padding-bottom: 2rem;
    }

    table.heading * {
        font-family: Arial, Helvetica, sans-serif;
    }

    table.main {
        width: 100%;
    }

    table.main td {
        border: 2px solid black;
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
</style>

<body>
    <footer style="padding: 0.5rem; text-align: left">
        <span style="margin-right: 150px">No. Dok: FSOP.KJB-7.3.4</span>
        <span style="margin-right: 150px">No.Revisi: 1</span>
    </footer>

    <table class="heading" style="margin-bottom: 2rem">
        <tr>
            <td>
                <img src="{{ public_path(App\Models\Setting::first()->kop_app) }}" width="80"
                    style="margin-left: 1.5rem">
            </td>
            <td style="text-align: center; width: 780px">
                <h3 style="margin: 0;">RANGKAIAN PENGAMANAN SAMPEL</h3>
                <h3 style="margin: 0;">NO. {{ $data->no_formulir }}</h3>
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

    <hr style="margin: 1rem 0">

    <table class="main" cellpadding="8" cellspacing="0">
        <tr>
            <td>
                <div>No. Sampel:</div>
                <div>{{ $data->kode }}</div>
            </td>
            <td>
                <div>Tanggal Diterima Sampel:</div>
                <div>
                    {{ App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse($data->tanggal_diterima)->format('Y-m-d')) }}
                </div>
            </td>
            <td>
                <div>Tanggal Selesai Sampel:</div>
                <div>
                    {{ App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse($data->tanggal_selesai)->format('Y-m-d')) }}
                </div>
            </td>
            <td>
                <div>Jumlah Sampel:</div>
                <div>{{ count($parametersUji) }}</div>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="background: #000"></td>
        </tr>
        <tr>
            <td style="text-align: center">Jenis Sampel</td>
            <td colspan="2" style="text-align: center">Parameter</td>
            <td>
                <div>Pengawetan Dilakukan oleh:</div>
                <div>{{ $data->pengawetan_oleh }}</div>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top">{{ $data->jenisSampel->nama }}</td>
            <td colspan="2" style="vertical-align: top">
                <ul style="margin: 0">
                    @foreach ($parametersUji as $param)
                        <li>{{ $param->nama }}</li>
                    @endforeach
                </ul>
            </td>
            <td style="vertical-align: top">
                <ul style="margin: 0">
                    @foreach ($pengawetans as $awet)
                        <li>{{ $awet->nama }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
        @if (!$data->kondisi_sampel)
            <tr>
                <td colspan="4">
                    <div>Kondisi sampel saat diterima termasuk abnormalitas atau penyimpangan dari kondisi normal</div>
                    <div>{{ $data->keterangan_kondisi_sampel }}</div>
                </td>
            </tr>
        @endif
    </table>
</body>

</html>
