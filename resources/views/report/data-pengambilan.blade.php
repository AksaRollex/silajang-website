<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Pengambilan</title>
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

    table.sub td,
    table.sub th {
        border: none !important;
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

    ul {
        margin: 0;
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
        <span style="margin-right: 150px">No.Revisi: 0</span>
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

    <h4 style="text-align: center">DATA PENGAMBILAN SAMPEL</h4>
    <table class="main" border="0" cellspacing="0" cellpadding="6">
        @if (isset($data->permohonan->user->detail))
            <tr>
                <td colspan="2">
                    <div>Nama Pelanggan / Perusahaan : </div>
                    <div>{{ $data->permohonan->user->detail->instansi }}</div>
                </td>
                <td>
                    <div>Alamat :</div>
                    <div>{{ $data->permohonan->user->detail->alamat }}</div>
                </td>
            </tr>
        @endif
        <tr>
            <td colspan="2">
                <div>Nama Personil Penghubung : </div>
                <div>{{ $data->permohonan->user->nama }}</div>
            </td>
            <td>
                <div>No. Telp / FAX / Email :</div>
                <div>{{ @$data->permohonan->user->detail->telepon ?? @$data->permohonan->user->phone }} /
                    {{ @$data->permohonan->user->detail->fax ?? '-' }}
                    / {{ @$data->permohonan->user->detail->email ?? @$data->permohonan->user->phone }}
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="background: #000; padding: 0.375rem 0"></td>
        </tr>
        <tr>
            <td colspan="2" rowspan="2">
                <div>Nama Pengambil Sampel : </div>
                <div>{{ implode(', ', $data->petugasPengambils->pluck('nama')->toArray()) }}</div>
            </td>
            <td>
                <div>Metode Pengujian : SNI</div>
            </td>
        </tr>
        <tr>
            <td>
                <div>Jenis Sampel : </div>
                <div>{{ $data->jenisSampel->nama }}</div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div>Tanggal Pengambilan Sampel : </div>
                <div>
                    {{ App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse($data->tanggal_pengambilan)->format('Y-m-d')) }}
                </div>
            </td>
            <td rowspan="3" style="vertical-align: top">
                <div>Cara Pengambilan Sampel : </div>
                <div>
                    {{ @$data->acuanMetode->nama }}
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div style="text-align: center">Waktu Pengambilan Sampel</div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div style="text-align: center">
                    {{ Illuminate\Support\Carbon::parse($data->tanggal_pengambilan)->format('H:i') }}</div>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="background: #000; padding: 0.375rem 0"></td>
        </tr>
    </table>

    <table class="main" border="0" cellspacing="0" cellpadding="6">
        <thead>
            <tr>
                <th>Titik Pengambilan Sampel</th>
                <th>Hasil Pengukuran Parameter Lapangan</th>
                <th>Pengawetan</th>
                <th>Parameter Uji</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data->parameters as $i => $param)
                <tr>
                    @if ($i == 0)
                        <td rowspan="5" style="vertical-align: top;">
                            <div>{{ $data->lokasi }}</div>
                            <div>S: {{ $data->south }}</div>
                            <div>E: {{ $data->east }}</div>
                        </td>
                        <td rowspan="5" style="vertical-align: top;">
                            <table border="0" class="sub" style="width: auto">
                                <tr>
                                    <td><span class="checkbox"></span> Suhu air</td>
                                    <td>:</td>
                                    <td>{{ $data->lapangan->suhu_air }} t&deg;C</td>
                                </tr>
                                <tr>
                                    <td><span class="checkbox"></span> pH</td>
                                    <td>:</td>
                                    <td>{{ $data->lapangan->ph }}</td>
                                </tr>
                                <tr>
                                    <td><span class="checkbox"></span> DHL</td>
                                    <td>:</td>
                                    <td>{{ $data->lapangan->dhl }} µS/cm</td>
                                </tr>
                                <tr>
                                    <td><span class="checkbox"></span> Salinitas</td>
                                    <td>:</td>
                                    <td>{{ $data->lapangan->salinitas }} ‰</td>
                                </tr>
                                <tr>
                                    <td><span class="checkbox"></span> DO</td>
                                    <td>:</td>
                                    <td>{{ $data->lapangan->do }} mg/L</td>
                                </tr>
                            </table>
                        </td>
                    @elseif ($i > 4)
                        <td></td>
                        <td></td>
                    @endif
                    <td>
                        @if (count($param->pengawetans))
                            <ul>
                                @foreach ($param->pengawetans as $awet)
                                    <li>{{ $awet->nama }}</li>
                                @endforeach
                            </ul>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $param->nama }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" style="background: #000; padding: 0.375rem 0"></td>
            </tr>
            <tr>
                <td colspan="4">
                    <div style="margin-block: 1rem">Kondisi lingkungan pengambilan sampel yang dapat mempengaruhi
                        interpretasi hasil pengujian:</div>
                    <table border="0" class="sub" cellpadding="8" style="width: auto">
                        <tr>
                            <td style="padding-right: 2rem">
                                <table>
                                    <tr>
                                        <td><span class="checkbox"></span> Suhu udara</td>
                                        <td>:</td>
                                        <td>{{ $data->lapangan->suhu_udara }} t0C</td>
                                    </tr>
                                    <tr>
                                        <td><span class="checkbox"></span> Arah angin</td>
                                        <td>:</td>
                                        <td>{{ $data->lapangan->arah_angin }}</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="padding-right: 2rem">
                                <table>
                                    <tr>
                                        <td><span class="checkbox"></span> Kelembapan</td>
                                        <td>:</td>
                                        <td>{{ $data->lapangan->kelembapan }} %RH</td>
                                    </tr>
                                    <tr>
                                        <td><span class="checkbox"></span> Kecepatan angin</td>
                                        <td>:</td>
                                        <td>{{ $data->lapangan->kecepatan_angin }}</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="vertical-align: top">
                                <table>
                                    <tr>
                                        <td><span class="checkbox"></span> Cuaca</td>
                                        <td>:</td>
                                        <td>{{ $data->lapangan->cuaca }} %RH</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    @if (count($data->photos))
        <h4 style="font-weight: 400; margin-top: 2rem">Foto Lapangan/Lokasi:</h4>
        <div style="margin-top: 2rem">
            @foreach ($data->photos as $photo)
                @if (is_file(public_path($photo->foto)))
                    <div
                        style="display: inline-block; width: 25%; height: 200px; background-image: url({{ public_path($photo->foto) }}); background-size: cover; background-repeat: no-repeat; background-position: center">
                    </div>
                @endif
            @endforeach
        </div>
    @endif

    <table border="0" style="margin-top: 4rem; page-break-inside: avoid">
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
