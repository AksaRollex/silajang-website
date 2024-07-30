<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RDPS {{ $data->no_formulir }}</title>
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
                <h3 style="margin: 0;">REKAPITULASI HASIL PENGUJIAN SEMENTARA</h3>
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

    {{-- 18 Cell --}}
    <table cellpadding="4" cellspacing="0">
        <tr>
            <td style="opacity: 0; width: 20px">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0; width: 20px">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
        </tr>
        <tr>
            <td colspan="3">No.</td>
            <td>:</td>
            <td>{{ $data->no_formulir }}</td>
        </tr>
        <tr>
            <td colspan="3">Jenis Sampel</td>
            <td>:</td>
            <td>{{ @$data->jenisSampel->nama }}</td>
        </tr>
        <tr>
            <td colspan="3">Peraturan</td>
            <td>:</td>
            <td>{{ @$data->peraturan->nama ? @$data->peraturan->nama . @$data->peraturan->nomor : '-' }}</td>
        </tr>
        <tr>
            <td colspan="3">Nomor Sampel</td>
            <td>:</td>
            <td>{{ $data->kode }}</td>
        </tr>
        <tr>
            <td colspan="3">Tanggal Pengujian</td>
            <td>:</td>
            <td>{{ App\Helpers\AppHelper::tanggal_indo(explode(' ', $data->tanggal_mulai_uji)[0]) }}
                {{ Illuminate\Support\Carbon::parse(explode(' ', $data->tanggal_mulai_uji)[1])->format('H:i') }} s/d
                {{ App\Helpers\AppHelper::tanggal_indo(explode(' ', $data->tanggal_selesai_uji)[0]) }}
                {{ Illuminate\Support\Carbon::parse(explode(' ', $data->tanggal_selesai_uji)[1])->format('H:i') }}</td>
        </tr>
        <tr>
            <td colspan="3">Jam Datang</td>
            <td>:</td>
            <td>{{ $data->jam_datang_uji }}</td>
        </tr>
    </table>

    <table class="main" cellpadding="5" cellspacing="0" style="margin-bottom: 1rem">
        <tr>
            <td style="opacity: 0; width: 20px">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
        </tr>
        <tr>
            <th>NO</th>
            <th>PARAMETER</th>
            <th>SATUAN</th>
            <th style="white-space: nowrap">BAKU MUTU (MIN/MAX)</th>
            <th>HASIL</th>
            <th>VERIFIKASI</th>
            <th>KETERANGAN</th>
        </tr>
        @foreach ($parametersUji as $i => $param)
            <tr>
                <td style="text-align: center">{{ $i + 1 }}</td>
                <td>{{ $param->nama }}</td>
                <td style="text-align: center">{{ $param->satuan }}</td>
                <td style="text-align: center">{{ $param->pivot->baku_mutu }}</td>
                <td style="text-align: center">{{ $param->pivot->hasil_uji }}</td>
                <td style="text-align: center">{{ $param->pivot->hasil_uji_pembulatan }}</td>
                <td style="text-align: center">
                    {{ $data->permohonan->is_mandiri ? '' : App\Models\TitikPermohonanParameter::getHasil($param->pivot) }}
                </td>
            </tr>
        @endforeach
    </table>

    <table cellpadding="5" cellspacing="0" style="width: auto">
        <tr>
            <td rowspan="4" style="vertical-align: top">Interpretasi Hasil Pengujian :</td>
            <td style="text-align: center">
                @if ($data->hasil_pengujian == 1)
                    <span class="checkbox check">V</span>
                @else
                    <span class="checkbox"></span>
                @endif
            </td>
            <td>Ada</td>
        </tr>
        <tr>
            <td style="text-align: center">
                @if ($data->hasil_pengujian == 0)
                    <span class="checkbox check">V</span>
                @else
                    <span class="checkbox"></span>
                @endif
            </td>
            <td>Tidak Ada</td>
        </tr>
        <tr>
            <td style="text-align: center">
                @if ($data->memenuhi_hasil_pengujian == 1)
                    <span class="checkbox check">V</span>
                @else
                    <span class="checkbox"></span>
                @endif
            </td>
            <td>Memenuhi Persyaratan</td>
        </tr>
        <tr>
            <td style="text-align: center">
                @if ($data->memenuhi_hasil_pengujian == 0)
                    <span class="checkbox check">V</span>
                @else
                    <span class="checkbox"></span>
                @endif
            </td>
            <td>Tidak Memenuhi Persyaratan</td>
        </tr>
    </table>

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
