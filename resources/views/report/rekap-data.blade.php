<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekap Data Berdasarkan {{ ucfirst($mode) }}</title>

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

    <h3 style="text-decoration: underline; text-align: center; margin: 0.25rem">
        Rekap Data Berdasarkan
        @if ($mode == 'sampel-permohonan')
            Sampel Permohonan
        @elseif ($mode == 'total-biaya')
            Total Biaya
        @elseif ($mode == 'metode')
            Metode
        @endif
    </h3>
    <div style="text-align: center; margin: 0.25rem;">
        Periode {{ App\Helpers\AppHelper::tanggal_indo($start) }} s/d {{ App\Helpers\AppHelper::tanggal_indo($end) }}
    </div>

    <br>

    <table class="main" border="0" cellpadding="4" cellspacing="0">
        <tr>
            <th>No.</th>
            <th>Kode</th>
            <th>Pelanggan</th>
            <th>Titik Uji/Lokasi</th>
            <th>Status</th>
            @if ($mode == 'sampel-permohonan')
                <th>Tanggal Diterima</th>
                <th>Tanggal Selesai</th>
            @elseif ($mode == 'total-biaya')
                <th>Harga</th>
                <th>Jasa Pengambilan</th>
                <th>Total Biaya</th>
            @elseif ($mode == 'metode')
                <th>Metode</th>
            @endif
        </tr>
        @php
            $total_biaya = 0;
        @endphp
        @foreach ($data as $i => $titik)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $titik->kode }}</td>
                <td>{{ $titik->permohonan->user->nama }}</td>
                <td>{{ $titik->lokasi }}</td>
                <td>{{ $titik->text_status }}</td>

                @if ($mode == 'sampel-permohonan')
                    <td>{{ $titik->tanggal_diterima }}</td>
                    <td>{{ $titik->tanggal_selesai }}</td>
                @elseif ($mode == 'total-biaya')
                    <td style="text-align: right">
                        {{ $titik->permohonan->user->golongan_id == 1 ? App\Helpers\AppHelper::rupiah($titik->harga) : '-' }}
                    </td>
                    <td style="text-align: right">
                        {{ $titik->permohonan->jasa_pengambilan_id && $titik->permohonan->user->golongan_id == 1 ? App\Helpers\AppHelper::rupiah($titik->permohonan->jasaPengambilan->harga) : '-' }}
                    </td>
                    <td style="text-align: right">
                        {{ $titik->permohonan->user->golongan_id == 1 ? App\Helpers\AppHelper::rupiah($titik->harga + (@$titik->permohonan->jasaPengambilan->harga ?? 0)) : '-' }}
                    </td>
                    @php
                        if ($titik->permohonan->user->golongan_id == 1) {
                            $total_biaya += $titik->harga + (@$titik->permohonan->jasaPengambilan->harga ?? 0);
                        }
                    @endphp
                @elseif ($mode == 'metode')
                    <td>{{ $titik->acuanMetode->nama }}</td>
                @endif
            </tr>
        @endforeach

        @if ($mode == 'total-biaya')
            <tr>
                <td colspan="7" style="text-align: right; font-weight: 700">Total</td>
                <td style="text-align: right; font-weight: 700">
                    {{ App\Helpers\AppHelper::rupiah($total_biaya) }}
                </td>
            </tr>
        @endif
    </table>

</body>

</html>
