<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Berita Acara</title>
</head>

<style>
    :root {
        font-size: 16px;
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
        <span style="margin-right: 150px">No. Dok: FSOP.KJB-15.2</span>
        <span style="margin-right: 150px">No.Revisi: 1</span>
    </footer>

    <table style="margin-bottom: 2rem;">
        <tr>
            <td>
                <img src="{{ public_path(App\Models\Setting::first()->kop_app) }}" width="80"
                    style="margin-left: 1.5rem">
            </td>
            <td style="text-align: center; width: 780px">
                <h4 style="margin: 0;">BERITA ACARA DAN REKAMAN DATA PENGAMBILAN SAMPEL</h4>
                <h4 style="margin: 0;">
                    UPT LABORATORIUM LINGKUNGAN KABUPATEN JOMBANG</h4>
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

    <div style="height: 2px; background: #5c5c5c; margin: 2px"></div>

    <h4 style="text-align: center">BERITA ACARA PENGAMBILAN SAMPEL</h4>
    <div style="margin-bottom: 1rem">Yang bertanda tangan di bawah ini :</div>

    <table border="0" cellpadding="5" cellspacing="0" style="margin-bottom: 1rem">
        @php
            $no = 1;
        @endphp
        @foreach ($data->petugasPengambils as $petugas)
            <tr>
                @if ($no === 1)
                    <td style="vertical-align: top" rowspan="{{ count($data->petugasPengambils) + 1 }}">Nama</td>
                    <td>:</td>
                @else
                    <td></td>
                @endif
                <td>{{ $no }}. {{ $petugas->nama }} (Petugas Sampling)</td>
            </tr>
            @php
                $no++;
            @endphp
        @endforeach
        <tr>
            <td></td>
            <td>{{ $no }}. {{ $data->permohonan->user->nama }} (Wakil Customer/Perusahaan)</td>
        </tr>
    </table>

    <div style="margin-bottom: 1rem">Telah dilakukan pengambil sampel dari :</div>
    <table border="0" cellpadding="5" cellspacing="0" style="margin-bottom: 1rem; width: auto">
        @if (isset($data->permohonan->user->detail))
            <tr>
                <td>Nama Perusahaan</td>
                <td>:</td>
                <td>{{ $data->permohonan->user->detail->instansi }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $data->permohonan->user->detail->alamat }}</td>
            </tr>
        @endif
        <tr>
            <td>Hari / Tanggal</td>
            <td>:</td>
            <td>{{ App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse($data->tanggal_pengambilan)->format('Y-m-d')) }}
            </td>
        </tr>
        <tr>
            <td>Obyek Pelayanan</td>
            <td>:</td>
            <td>{{ $data->obyek_pelayanan }}</td>
        </tr>
    </table>

    <div style="margin-bottom: 1rem">Untuk dianalisa di Laboratorium Lingkungan Dinas Lingkungan Hidup Jombang</div>
    <table class="main" border="0" cellpadding="5" cellspacing="0" style="margin-bottom: 1rem">
        <thead>
            <th>No.</th>
            <th>Lokasi / Titik Sampling</th>
            <th>Jam</th>
            <th>Parameter</th>
            <th>Keterangan</th>
        </thead>
        <tbody>
            @foreach ($data->parameters as $i => $param)
                <tr>
                    @if ($i == 0)
                        <td rowspan="{{ count($data->parameters) }}">1</td>
                        <td rowspan="{{ count($data->parameters) }}">{{ $data->lokasi }}</td>
                        <td rowspan="{{ count($data->parameters) }}">
                            {{ Illuminate\Support\Carbon::parse($data->tanggal_pengambilan)->format('H:i') }}</td>
                    @endif
                    <td>{{ $param->nama }}</td>
                    <td>{{ $param->pivot->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table border="0" style="margin-top: 2rem; page-break-inside: avoid">
        <tr>
            <td style="text-align: center">
                <div style="opacity: 0">Jombang, {{ App\Helpers\AppHelper::tanggal_indo(date('Y-m-d')) }}</div>
                <div>{{ @$data->pengambil->nama }}</div>
                @if (@$data->pengambil->detail->tanda_tangan)
                    <img src="{{ public_path($data->pengambil->detail->tanda_tangan) }}" class="ttd">
                @else
                    <br><br><br><br><br><br>
                @endif
                <div>.........................................</div>
            </td>
            <td style="text-align: center">
                <div>Jombang, {{ App\Helpers\AppHelper::tanggal_indo(date('Y-m-d')) }}</div>
                <div>{{ $data->permohonan->user->nama }}</div>
                @if (@$data->permohonan->user->detail->tanda_tangan)
                    <img src="{{ public_path($data->permohonan->user->detail->tanda_tangan) }}" class="ttd">
                @else
                    <br><br><br><br><br><br>
                @endif
                <div>.........................................</div>
            </td>
        </tr>
    </table>
</body>

</html>
