<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekap Parameter</title>

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

        footer {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            text-align: center;
            border-top: 2px solid black;
        }
    </style>
</head>

<body>

    <table class="heading" style="margin-bottom: 2rem">
        <tr>
            <td>
                <img src="{{ public_path('media/logo-jombang.png') }}" width="80" style="margin-left: 1.5rem">
            </td>
            <td style="text-align: center; width: 780px">
                <h2 style="margin: 0;">PEMERINTAH KABUPATEN JOMBANG</h2>
                <h2 style="margin: 0;">DINAS LINGKUNGAN HIDUP KABUPATEN JOMBANG</h2>
                <h2 style="margin: 0;">UPT LABORATORIUM LINGKUNGAN KABUPATEN JOMBANG</h2>
                <h4 style="margin: 0;">{{ $setting->alamat }} Telp. {{ $setting->telepon }}
                </h4>
                <h4 style="margin: 0;">Email: {{ $setting->email }}, Website: {{ url('') }}
                </h4>
            </td>
            <td style="text-align: center;">
                <div style="transform: translateX(-2rem)">
                    <img src="{{ public_path(App\Models\Setting::first()->kop_sni) }}" width="150">
                    <div style="font-size: 12px;">Laboratorium Penguji</div>
                    <div style="font-size: 12px;">LP-1154-IDN</div>

                    <div style="font-size: 8px; font-weight: 700; margin-top: 1rem">No. Reg. Kompetensi :</div>
                    <div style="font-size: 8px; font-weight: 700;">00197/LPJ/LABLING-1/LRK/KLHK</div>
                </div>
            </td>
        </tr>
    </table>

    <div style="height: 2px; background: #5c5c5c; margin: 2px"></div>
    <div style="height: 5px; background: #5c5c5c; margin: 2px"></div>

    <br><br>

    <h1 style="text-decoration: underline; text-align: center; margin: 0.25rem">Rekap Parameter</h1>
    <div style="text-align: center; margin: 0.25rem;">{{ $start }} s/d {{ $end }}</div>

    <br>

    <table class="main" border="0" cellpadding="4" cellspacing="0">
        <tr>
            <th>Parameter</th>
            <th>Metode</th>
            <th>Satuan</th>
            <th>Terdapat di..</th>
        </tr>
        @foreach ($data as $param)
            @foreach ($param->titikPermohonans as $i => $titik)
                @if ($i == 0)
                    <tr>
                        <td style="vertical-align: top" rowspan="{{ $param->titikPermohonans->count() }}">
                            {{ $param->nama }}
                            {{ $param->keterangan ? "($param->keterangan)" : '' }} <span
                                style="font-size: 0.8rem">{{ $param->jenisParameter->nama }}</span></td>
                        <td style="vertical-align: top" rowspan="{{ $param->titikPermohonans->count() }}">
                            {{ $param->metode }}</td>
                        <td style="vertical-align: top" rowspan="{{ $param->titikPermohonans->count() }}">
                            {{ $param->satuan }}</td>
                        <td>{{ $titik->kode != '(Belum Ditetapkan)' ? "($titik->kode)" : $titik->kode }}
                            {{ $titik->lokasi }}</td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $titik->kode != '(Belum Ditetapkan)' ? "($titik->kode)" : $titik->kode }}
                            {{ $titik->lokasi }}</td>
                    </tr>
                @endif
            @endforeach
        @endforeach
    </table>

</body>

</html>
