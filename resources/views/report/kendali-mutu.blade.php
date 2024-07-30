<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kendali Mutu {{ $data->no_formulir }}</title>
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

    footer.pagenote {
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

    footer.tte {
        position: fixed;
        bottom: -3rem;
        left: 0px;
        right: 0px;
        text-align: center;
    }
</style>

<body>
    @if (isset($tte) && $tte)
        <footer class="tte" style="padding: 0.5rem; text-align: left; margin-top: 2rem">
            <img src="{{ public_path('media/bse.png') }}" width="100" style="margin-bottom: -1rem">
            <div style="text-align: center">
                <em style="font-family: Arial, Helvetica, sans-serif; font-size: 0.8rem">Dokumen ini telah
                    ditandatangani
                    secara elektronik
                    yang diterbitkan oleh Balai Sertifikasi
                    Elektronik(BSrE), BSSN</em>
            </div>
        </footer>
    @endif

    <footer class="pagenote" style="padding: 0.5rem; text-align: left">
        <span style="margin-right: 150px">No. Dok: FSOP.KJB-7.1.2</span>
        <span style="margin-right: 150px">No.Revisi: 1</span>
    </footer>

    <table style="margin-bottom: 2rem">
        <tr>
            <td>
                <img src="{{ public_path(App\Models\Setting::first()->kop_app) }}" width="80"
                    style="margin-left: 1.5rem">
            </td>
            <td style="text-align: center; width: 780px">
                <h2 style="margin: 0;">FORMULIR KENDALI PROSES</h2>
                <h2 style="margin: 0;">
                    UPT LABORATORIUM LINGKUNGAN KABUPATEN JOMBANG</h2>
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
            <td>Jenis Sampel</td>
            <td>:</td>
            <td>{{ $data->jenisSampel->nama }}</td>
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
            <th style="text-align: center; width: 120">Perihal</th>
            <th style="text-align: center">Dari</th>
            <th style="text-align: center">Kepada</th>
            <th style="text-align: center">Tanggal Diserahkan</th>
            <th style="text-align: center">Tanggal Diterima</th>
            <th style="text-align: center">Keterangan</th>
        </tr>

        <tr>
            <td>1</td>
            <td>Menyerahkan Sampel</td>
            <td>PPC/Pelanggan</td>
            <td>Koordinator Administrasi</td>
            @if ($data->status >= 1)
                <td>{{ isset($tracks[1]) ? App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse(@$data->tanggal_pengambilan)->format('Y-m-d'), true) : '' }}
                </td>
                <td>{{ isset($tracks[1]) ? App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse(@$tracks[1]->created_at)->format('Y-m-d'), true) : '' }}
                </td>
                <td>{{ @$tracks[1]->keterangan }}</td>
            @else
                <td></td>
                <td></td>
                <td></td>
            @endif
        </tr>

        <tr>
            <td>2</td>
            <td>Menyerahkan Surat Perintah Pengujian</td>
            <td>Koordinator Administrasi</td>
            <td>Koordinator Teknis</td>
            @if ($data->status >= 2)
                <td>{{ isset($tracks[2]) ? App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse(@$tracks[1]->created_at)->format('Y-m-d'), true) : '' }}
                </td>
                <td>{{ isset($tracks[2]) ? App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse(@$tracks[2]->created_at)->format('Y-m-d'), true) : '' }}
                </td>
                <td>{{ @$tracks[2]->keterangan }}</td>
            @else
                <td></td>
                <td></td>
                <td></td>
            @endif
        </tr>

        <tr>
            <td>3</td>
            <td>Menyerahkan sampel untuk proses pengujian</td>
            <td>Koordinator Teknis</td>
            <td>Analis</td>
            @if ($data->status >= 3)
                <td>{{ isset($tracks[3]) ? App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse(@$tracks[2]->created_at)->format('Y-m-d'), true) : '' }}
                </td>
                <td>{{ isset($tracks[3]) ? App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse(@$tracks[3]->created_at)->format('Y-m-d'), true) : '' }}
                </td>
                <td>{{ @$tracks[3]->keterangan }}</td>
            @else
                <td></td>
                <td></td>
                <td></td>
            @endif
        </tr>

        <tr>
            <td>4</td>
            <td>Menyerahkan RDPS</td>
            <td>Analisis</td>
            <td>Koordinator Teknis</td>
            @if ($data->status >= 4)
                <td>{{ isset($tracks[4]) ? App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse(@$tracks[3]->created_at)->format('Y-m-d'), true) : '' }}
                </td>
                <td>{{ isset($tracks[4]) ? App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse(@$tracks[4]->created_at)->format('Y-m-d'), true) : '' }}
                </td>
                <td>{{ @$tracks[4]->keterangan }}</td>
            @else
                <td></td>
                <td></td>
                <td></td>
            @endif
        </tr>

        <tr>
            <td>5</td>
            <td>Menyerahkan RDPS untuk Pengetikan LHU</td>
            <td>Koordinator Teknis</td>
            <td>Koordinator Administrasi</td>
            @if ($data->status >= 5)
                <td>{{ isset($tracks[5]) ? App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse(@$tracks[4]->created_at)->format('Y-m-d'), true) : '' }}
                </td>
                <td>{{ isset($tracks[5]) ? App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse(@$tracks[5]->created_at)->format('Y-m-d'), true) : '' }}
                </td>
                <td>{{ @$tracks[5]->keterangan }}</td>
            @else
                <td></td>
                <td></td>
                <td></td>
            @endif
        </tr>

        <tr>
            <td>6</td>
            <td>Menyerahkan LHU untuk Diverifikasi</td>
            <td>Koordinator Administrasi</td>
            <td>Koordinator Teknis</td>
            @if ($data->status >= 6)
                <td>{{ isset($tracks[6]) ? App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse(@$tracks[5]->created_at)->format('Y-m-d'), true) : '' }}
                </td>
                <td>{{ isset($tracks[6]) ? App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse(@$tracks[6]->created_at)->format('Y-m-d'), true) : '' }}
                </td>
                <td>{{ @$tracks[6]->keterangan }}</td>
            @else
                <td></td>
                <td></td>
                <td></td>
            @endif
        </tr>

        <tr>
            <td>7</td>
            <td>Mengesahkan LHU</td>
            <td>Koordinator Administrasi</td>
            <td>Kepala UPT LabLing</td>
            @if ($data->status >= 7)
                <td>{{ isset($tracks[7]) ? App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse(@$tracks[6]->created_at)->format('Y-m-d'), true) : '' }}
                </td>
                <td>{{ isset($tracks[7]) ? App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse(@$tracks[7]->created_at)->format('Y-m-d'), true) : '' }}
                </td>
                <td>{{ @$tracks[7]->keterangan }}</td>
            @else
                <td></td>
                <td></td>
                <td></td>
            @endif
        </tr>

        <tr>
            <td>8</td>
            <td>Pembayaran</td>
            <td>Koordinator Administrasi</td>
            <td>Pelanggan</td>
            @if ($data->status >= 8)
                <td>{{ isset($tracks[8]) ? App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse(@$tracks[7]->created_at)->format('Y-m-d'), true) : '' }}
                </td>
                <td>{{ isset($tracks[8]) ? App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse(@$tracks[8]->created_at)->format('Y-m-d'), true) : '' }}
                </td>
                <td>{{ @$tracks[8]->keterangan }}</td>
            @else
                <td></td>
                <td></td>
                <td></td>
            @endif
        </tr>

        <tr>
            <td>9</td>
            <td>Penyerahan LHU</td>
            <td>Koordinator Administrasi</td>
            <td>Pelanggan</td>
            @if ($data->status >= 9)
                <td>{{ isset($tracks[9]) ? App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse(@$tracks[8]->created_at)->format('Y-m-d'), true) : '' }}
                </td>
                <td>{{ isset($tracks[9]) ? App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse(@$tracks[9]->created_at)->format('Y-m-d'), true) : '' }}
                </td>
                <td>{{ @$tracks[9]->keterangan }}</td>
            @else
                <td></td>
                <td></td>
                <td></td>
            @endif
        </tr>

        <tr>
            <td>10</td>
            <td>Penyerahan LHU Amandemen (Jika ada)</td>
            <td>Koordinator Administrasi</td>
            <td>Pelanggan</td>
            @if ($data->status >= 10)
                <td>{{ isset($tracks[10]) ? App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse(@$tracks[9]->created_at)->format('Y-m-d'), true) : '' }}
                </td>
                <td>{{ isset($tracks[10]) ? App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse(@$tracks[10]->created_at)->format('Y-m-d'), true) : '' }}
                </td>
                <td>{{ @$tracks[10]->keterangan }}</td>
            @else
                <td></td>
                <td></td>
                <td></td>
            @endif
        </tr>
    </table>

    <table style="margin-top: 2rem; page-break-inside: avoid">
        <tr>
            <td style="opacity: 0; width: 60%">-</td>
            <td style="width: 40%; text-align: center">
                <div>Jombang, {{ App\Helpers\AppHelper::tanggal_indo(date('Y-m-d')) }}</div>
                <div>{{ $ttd->jabatan }}</div>
                @if ($tte)
                    @if (isset($qrCode))
                        <img src="{{ $qrCode }}" style="margin: 2rem 0">
                    @else
                        <div style="text-align: center; height: 15rem; line-height: 10rem">
                            <span>$</span>
                        </div>
                    @endif
                @elseif (@$ttd->tanda_tangan)
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
