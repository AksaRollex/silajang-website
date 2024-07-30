<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Permohonan Disampling {{ $data->no_formulir }}</title>
</head>

<style>
    :root {
        font-size: 12px;
    }

    body {
        font-family: Times New Roman, serif;
        margin: 0px;
        padding: 0px;
        padding-bottom: 2rem;
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

    .ttd {
        width: 100%;
        height: 100px;
        object-fit: contain;
    }
</style>

<body>
    <footer style="padding: 0.5rem; text-align: left">
        <span style="margin-right: 150px">No. Dok: FSOP.KJB-15.3</span>
        <span style="margin-right: 150px">No.Revisi/Terbit: 0/2</span>
    </footer>

    <table style="margin-bottom: 2rem">
        <tr>
            <td>
                <img src="{{ public_path(App\Models\Setting::first()->kop_app) }}" width="80"
                    style="margin-left: 1.5rem">
            </td>
            <td style="text-align: center; width: 780px">
                <h2 style="margin: 0;">PERMOHONAN PENGUJIAN</h2>
                <h2 style="margin: 0;">NO. {{ $data->no_formulir }}</h2>
                <h2 style="margin: 0;">
                    UPT LABORATORIUM LINGKUNGAN KABUPATEN JOMBANG</h2>
                <h3 style="margin: 0;">
                    TANGGAL PERMOHONAN :
                    {{ App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse($data->created_at)->format('Y-m-d')) }}
                </h3>
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
    <table class="main" cellpadding="8" cellspacing="0">
        <tr>
            <td style="opacity: 0; width: 20px">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
            <td style="opacity: 0">-</td>
        </tr>
        <tr>
            <td colspan="3">Nama Pelanggan/Perusahaan :</td>
            <td colspan="15">{{ $data->permohonan->industri }}</td>
        </tr>
        <tr>
            <td colspan="3">Alamat :</td>
            <td colspan="15">{{ $data->permohonan->alamat }}</td>
        </tr>
        <tr>
            <td colspan="3">Nama Personil Penghubung :</td>
            <td colspan="15">{{ $data->permohonan->user->nama }}</td>
        </tr>
        @if (isset($data->permohonan->user->detail))
            <tr>
                <td colspan="3">No. HP/Alamat Email :</td>
                <td colspan="15">{{ $data->permohonan->user->detail->telepon }} /
                    {{ $data->permohonan->user->detail->email }}</td>
            </tr>
        @endif
        <tr>
            <td colspan="3" rowspan="2" style="text-align: center">
                <div>Pengambilan Sampel Dilakukan oleh :</div>
                <div>{{ $data->pengambil->nama }}</div>
            </td>
            <td colspan="3" rowspan="2" style="text-align: center;">
                <div>Acuan Perundangan :</div>
                <div>{{ @$data->peraturan->nama }} {{ @$data->peraturan->nomor }}</div>
            </td>
            <td colspan="5" style="text-align: center">Interpretasi Hasil Pengujian</td>
            <td colspan="7" style="text-align: center">Kesimpulan Permohonan</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center">
                <span class="checkbox check">
                    @if ($data->hasil_pengujian == 1)
                        V
                    @endif
                </span>
                Ada
            </td>
            <td colspan="3" style="text-align: center">
                <span class="checkbox"></span>
                Tidak
            </td>
            <td colspan="4" style="text-align: center">
                <span class="checkbox check">
                    @if ($data->kesimpulan_permohonan == 1)
                        V
                    @endif
                </span>
                Diterima
            </td>
            <td colspan="3" style="text-align: center">
                <span class="checkbox"></span>
                Ditolak
            </td>
        </tr>
        <tr>
            <td style="text-align: center" rowspan="3">No</td>
            <td style="text-align: center" rowspan="3">Jenis Sampel</td>
            <td style="text-align: center" rowspan="3">Jenis Wadah</td>
            <td style="text-align: center" rowspan="3">Parameter Uji</td>
            <td style="text-align: center" rowspan="3">Metode Uji</td>
            <td style="text-align: center" rowspan="3">Biaya</td>
            <td style="text-align: center" colspan="12">Kajiulang Permintaan</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center">Personel</td>
            <td colspan="2" style="text-align: center">Metode</td>
            <td colspan="2" style="text-align: center">Peralatan</td>
            <td colspan="2" style="text-align: center">Reagen</td>
            <td colspan="2" style="text-align: center">Akomodasi</td>
            <td colspan="2" style="text-align: center">Beban Kerja</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center">Mampu</td>
            <td colspan="2" style="text-align: center">Sesuai</td>
            <td colspan="2" style="text-align: center">Lengkap</td>
            <td colspan="2" style="text-align: center">Lengkap</td>
            <td colspan="2" style="text-align: center">Baik</td>
            <td colspan="2" style="text-align: center">Over</td>
        </tr>

        @php
            $total_biaya = 0;
        @endphp
        @foreach ($parametersUji as $i => $param)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $data->jenisSampel->nama }}</td>
                <td>{{ implode(', ', $data->jenisWadahs->map(fn($a) => $a->nama . ($a->keterangan ? " ($a->keterangan)" : ''))->toArray()) }}
                </td>
                <td>{{ $param->nama }}</td>
                <td>{{ $param->metode }}</td>
                @if ($data->permohonan->user->golongan_id == 1)
                    <td style="text-align: right">{{ App\Helpers\AppHelper::rupiah($param->pivot->harga) }}</td>

                    {{-- @php
                        $total_biaya += $param->pivot->harga;
                    @endphp --}}
                @else
                    <td style="text-align: right"></td>
                @endif

                <td colspan="2" style="text-align: center">
                    @if ($param->pivot->personel == 1)
                        V
                    @else
                        -
                    @endif
                </td>
                <td colspan="2" style="text-align: center">
                    @if ($param->pivot->metode == 1)
                        V
                    @else
                        -
                    @endif
                </td>
                <td colspan="2" style="text-align: center">
                    @if ($param->pivot->peralatan == 1)
                        V
                    @else
                        -
                    @endif
                </td>
                <td colspan="2" style="text-align: center">
                    @if ($param->pivot->reagen == 1)
                        V
                    @else
                        -
                    @endif
                </td>
                <td colspan="2" style="text-align: center">
                    @if ($param->pivot->akomodasi == 1)
                        V
                    @else
                        -
                    @endif
                </td>
                <td colspan="2" style="text-align: center">
                    @if ($param->pivot->beban_kerja == 1)
                        V
                    @else
                        -
                    @endif
                </td>
            </tr>
        @endforeach

        @if ($data->permohonan->user->golongan_id == 1)
            <tr>
                <td colspan="5" style="text-align: right">Biaya Jasa Pengambilan
                    ({{ $data->permohonan->jasaPengambilan->wilayah }}) :</td>
                <td style="text-align: right">
                    {{ App\Helpers\AppHelper::rupiah($data->permohonan->jasaPengambilan->harga) }}</td>
                <td colspan="12"></td>
            </tr>
            @php
                $total_biaya += $data->permohonan->jasaPengambilan->harga;
            @endphp
        @endif

        @if ($data->permohonan->user->golongan_id == 1 && isset($data->permohonan->radiusPengambilan))
            <tr>
                <td colspan="5" style="text-align: right">Biaya Jasa Pengambilan Tambahan
                    ({{ $data->permohonan->radiusPengambilan->radius }}m):
                </td>
                <td style="text-align: right">
                    {{ App\Helpers\AppHelper::rupiah($data->permohonan->radiusPengambilan->harga) }}</td>
                <td colspan="12"></td>
            </tr>
            @php
                $total_biaya += $data->permohonan->radiusPengambilan->harga;
            @endphp
        @endif

        @if ($data->permohonan->user->golongan_id == 1)
            <tr>
                <td colspan="5" style="text-align: right">Total Biaya yang Harus Dibayar :</td>
                <td style="text-align: right">{{ App\Helpers\AppHelper::rupiah($total_biaya + $data->harga) }}</td>
                <td colspan="12"></td>
            </tr>
        @endif

        <tr>
            <td colspan="3">
                <div>Nama Laboratorium Subkontrak :</div>
                <div style="height: 100px; margin-top: 1rem">
                    {{ $data->lab_subkontrak }}
                </div>
            </td>
            <td colspan="3">
                <div>Parameter Subkontrak :</div>
                <div style="height: 100px; margin-top: 1rem">
                    @foreach ($parametersSubkontrak as $i => $param)
                        @if ($i < $parametersSubkontrak->count() - 1)
                            <span>{{ $param->nama }},</span>
                        @else
                            <span>{{ $param->nama }}</span>
                        @endif
                    @endforeach
                </div>
            </td>
            <td colspan="3" style="text-align: center">
                <div>Tanda Tangan Pelanggan :</div>
                <div style="height: 100px">
                    @if (@$data->permohonan->user->detail->tanda_tangan)
                        <img src="{{ public_path($data->permohonan->user->detail->tanda_tangan) }}" class="ttd">
                    @endif
                </div>
                <div style="font-size: 0.85rem">{{ $data->permohonan->user->nama }}</div>
            </td>
            <td colspan="5" style="text-align: center">
                <div>Tanda tangan Koordinator Administrasi :</div>
                <div style="height: 100px">
                    @if ($ttdKoradmin->tanda_tangan)
                        <img src="{{ public_path($ttdKoradmin->tanda_tangan) }}" class="ttd">
                    @endif
                </div>
                <div style="font-size: 0.85rem">{{ $ttdKoradmin->nama }}</div>
            </td>
            <td colspan="4" style="text-align: center">
                <div>Tanda tangan Koordinator Teknis :</div>
                <div style="height: 100px">
                    @if ($ttdKortek->tanda_tangan)
                        <img src="{{ public_path($ttdKortek->tanda_tangan) }}" class="ttd">
                    @endif
                </div>
                <div style="font-size: 0.85rem">{{ $ttdKortek->nama }}</div>
            </td>
        </tr>
    </table>
</body>

</html>
