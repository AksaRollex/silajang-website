<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @if (isset($preview) && $preview)
        <title>Preview LHU {{ $data->no_formulir }}</title>
    @else
        <title>Laporan Hasil Pengujian {{ $data->no_formulir }}</title>
    @endif
</head>

<style>
    @page {
        margin: 0.7cm;
    }

    :root {
        font-size: 12px;
    }

    body {
        font-family: Times New Roman, serif;
        margin: 0px;
        padding: 0px;
        padding-bottom: 5rem;
    }

    .heading * {
        font-family: Arial, Helvetica, sans-serif;
    }

    #garis2 {
        border-top: 3px double black;
        margin: 0;
    }

    table {
        width: 100%;
    }

    table.main td,
    table.main th,
    tr.main td,
    tr.main th {
        border: 1px solid black;
    }

    table.main th,
    tr.main th {
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

    #watermark {
        position: fixed;
        top: 50%;
        left: 50%;
        z-index: 10;
        transform: translate(-55%, -55%);
        opacity: 0.25;
        width: 80%;
    }

    #watermark-lhu {
        position: fixed;
        top: 50%;
        left: 52.2%;
        z-index: 10;
        transform: translate(-55%, -55%);
        opacity: 0.7;
        width: 105%;
    }

    .italic * {
        font-style: italic;
    }

    .bold * {
        font-weight: 700;
    }

    .ttd {
        width: 150px;
        height: 100px;
        object-fit: contain;
    }

    footer.tte {
        position: fixed;
        bottom: 0.5rem;
        left: 0px;
        right: 0px;
        text-align: center;
    }

    .footnote {
        position: absolute;
        top: -20px;
        left: 0px;
        font-size: 8px;
    }
</style>

<body>
    <img src="{{ storage_path('app/watermark-lhu.jpeg') }}" id="watermark-lhu" alt="">
    @if (isset($preview) && $preview)
        <img src="{{ public_path('media/watermark-preview.png') }}" id="watermark" alt="">
    @endif

    @if (!@$preview)
        <div class="footnote">
            {{ date('d/m/Y H:i') }}
            @if ($data->sertifikat >= 1)
                - Salinan ke-{{ $data->sertifikat }}
            @endif
        </div>
    @endif

    <footer class="tte" style="padding: 0.5rem; text-align: left; margin-top: 1rem">
        @if (isset($tte) && $tte)
            <img src="{{ public_path('media/bse.png') }}" width="75" style="position: absolute; left: 0">
        @endif
        <div style="text-align: center">
            <em style="font-family: Arial, Helvetica, sans-serif; font-size: 0.7rem">Sertifikat pengujian ini hanya
                berlaku untuk jenis dan kode contoh uji yang tertera serta tidak boleh digandakan kecuali seluruhnya
                tanpa persetujuan dari laboratorium</em>
            <br>
            @if (isset($tte) && $tte)
                <em style="font-family: Arial, Helvetica, sans-serif; font-size: 0.7rem">Dokumen ini telah
                    ditandatangani
                    secara elektronik
                    yang diterbitkan oleh Balai Sertifikasi
                    Elektronik(BSrE), BSSN</em>
            @endif
        </div>
    </footer>

    <table style="page-break-inside: auto" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <td colspan="8">
                    <table class="heading" style="margin-bottom: 0rem; margin-top:0px;">
                        <tr>
                            <td>
                                <img src="{{ public_path(App\Models\Setting::first()->kop_app) }}" width="60"
                                    style="margin-left: 1.5rem">
                            </td>
                            <td style="text-align: center; width: 525px">
                                <h2 style="margin: 0;">PEMERINTAH KABUPATEN JOMBANG</h2>
                                <h2 style="margin: 0;">DINAS LINGKUNGAN HIDUP</h2>
                                <h2 style="margin: 0;">UPT LABORATORIUM LINGKUNGAN</h2>
                                <p style="margin: 0; font-size: 0.7rem">{{ $setting->alamat }} Telp.
                                    {{ $setting->telepon }}
                                </p>
                                <p style="margin: 0; font-size: 0.7rem">Email: {{ $setting->email }}, Website:
                                    {{ url('') }}
                                </p>
                            </td>
                            <td style="text-align: center;">
                                <div>
                                    <img src="{{ public_path(App\Models\Setting::first()->kop_sni) }}" width="100">
                                    <div style="font-size: 10px;">Laboratorium Penguji</div>
                                    <div style="font-size: 10px;">LP-1154-IDN</div>

                                    <div style="font-size: 7px; font-weight: 700; margin-top: 1rem">No. Reg. Kompetensi
                                        :</div>
                                    <div style="font-size: 7px; font-weight: 700;">00197/LPJ/LABLING-1/LRK/KLHK</div>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <div>
                        <hr id="garis2">
                    </div>
                    <br>
                </td>
            </tr>
            <tr>
                <td colspan="8">
                    <table border="0" cellpadding="1" cellspacing="0">
                        <tr style="text-align: center">
                            <td colspan="8" style="text-decoration: underline; font-weight: 700">LAPORAN HASIL
                                PENGUJIAN</td>
                        </tr>
                        <tr style="text-align: center">
                            <td colspan="8">{{ $data->no_lhu }}</td>
                        </tr>
                        <tr style="font-weight:500;">
                            <td>I.</td>
                            <td colspan="3">UMUM</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 250px">1. Kode Sampel/Contoh Uji</td>
                            <td style="width: 20px">:</td>
                            <td>{{ $data->kode }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 250px">2. Nama Industri/Kegiatan/Usaha</td>
                            <td style="width: 20px">:</td>
                            <td>{{ $data->permohonan->industri }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 250px">3. Alamat</td>
                            <td style="width: 20px">:</td>
                            <td>{{ $data->permohonan->alamat }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 250px">4. Telp/FAX</td>
                            <td style="width: 20px">:</td>
                            <td>{{ @$data->permohonan->user->detail->telepon ?? $data->permohonan->user->phone }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 250px">5. Jenis Industri/Kegiatan/Usaha</td>
                            <td style="width: 20px">:</td>
                            <td>{{ $data->permohonan->kegiatan }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 250px">6. Jenis Sampel/Contoh Uji</td>
                            <td style="width: 20px">:</td>
                            <td>{{ @$data->jenisSampel->nama }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 250px">7. Rentang Pengujian</td>
                            <td style="width: 20px">:</td>
                            <td>{{ App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse($data->tanggal_diterima)->format('Y-m-d')) }}
                                s/d
                                {{ App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse($data->tanggal_selesai)->format('Y-m-d')) }}
                            </td>
                        </tr>
                        @php
                            $nomer = 1;
                        @endphp
                        <tr style="font-weight:500;">
                            <td>II.</td>
                            <td colspan="3">DATA PENGIRIM SAMPEL</td>
                        </tr>
                        @if (isset($data->permohonan->user->detail))
                            <tr>
                                <td></td>
                                <td style="width: 250px">{{ $nomer }}. Nama/Instansi</td>
                                <td style="width: 20px">:</td>
                                <td>{{ $data->permohonan->user->detail->instansi }}</td>
                                @php
                                    $nomer++;
                                @endphp
                            </tr>
                            <tr>
                                <td></td>
                                <td style="width: 250px">{{ $nomer }}. Alamat</td>
                                <td style="width: 20px">:</td>
                                <td>{{ $data->permohonan->user->detail->alamat }}</td>
                                @php
                                    $nomer++;
                                @endphp
                            </tr>
                        @endif
                        @if (!$data->permohonan->is_mandiri)
                            <tr>
                                <td></td>
                                <td style="width: 250px">{{ $nomer }}. Petugas Pengambil Sampel</td>
                                <td style="width: 20px">:</td>
                                <td>{{ @$data->pengambil->nama }}</td>
                                @php
                                    $nomer++;
                                @endphp
                            </tr>
                            <tr>
                                <td></td>
                                <td style="width: 250px">{{ $nomer }}. Tanggal/Jam Pengambilan Sampel</td>
                                <td style="width: 20px">:</td>
                                <td>{{ App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse($data->tanggal_pengambilan)->format('Y-m-d')) }}
                                    /
                                    Jam
                                    {{ Illuminate\Support\Carbon::parse($data->tanggal_pengambilan)->format('H:i') }}
                                </td>
                                @php
                                    $nomer++;
                                @endphp
                            </tr>
                        @endif
                        <tr>
                            <td></td>
                            <td style="width: 250px">{{ $nomer }}. Tanggal/Jam Diterima Laboratorium</td>
                            <td style="width: 20px">:</td>
                            <td>{{ App\Helpers\AppHelper::tanggal_indo(Illuminate\Support\Carbon::parse($data->tanggal_diterima)->format('Y-m-d')) }}
                                /
                                Jam {{ Illuminate\Support\Carbon::parse($data->tanggal_diterima)->format('H:i') }}
                            </td>
                            @php
                                $nomer++;
                            @endphp
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 250px">{{ $nomer }}. Lokasi/Titik Pengambilan Sampel</td>
                            <td style="width: 20px">:</td>
                            <td>
                                {{ $data->lokasi }} S: {{ $data->south }} E: {{ $data->east }}
                            </td>
                            @php
                                $nomer++;
                            @endphp
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 250px">{{ $nomer }}. Metode Pengambilan Sampel</td>
                            <td style="width: 20px">:</td>
                            <td>
                                {{ @$data->acuanMetode->nama }}
                            </td>
                            @php
                                $nomer++;
                            @endphp
                        </tr>
                    </table>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>III.</th>
                <th colspan="7" style="text-align: left">HASIL PENGUJIAN</th>
            </tr>
            @php
                $alpha = 'A';
            @endphp
            @foreach ($parametersUji as $group => $parameters)
                <tr>
                    <td style="width: 20px">
                        <div style="margin: 1rem 0 0.5rem 0">{{ $alpha }}.</div>
                    </td>
                    <td colspan="7">
                        <h4 style="margin: 1rem 0 0.5rem 0">{{ explode('-', $group)[1] }}</h4>
                    </td>
                </tr>
                <tr class="main" style="page-break-inside: always">
                    <th style="border: none"></th>
                    <th style="width: 35px">No.</th>
                    <th>Parameter</th>
                    <th>Satuan</th>
                    <th>Hasil Uji</th>
                    <th>Baku Mutu*</th>
                    <th>Metode Analisa</th>
                    <th>Keterangan</th>
                </tr>
                @foreach ($parameters as $i => $param)
                    <tr style="page-break-inside: always"
                        class="main {{ App\Models\TitikPermohonanParameter::getHasil($param->pivot) == 'Tidak Memenuhi' && $param->pivot->baku_mutu != '-' ? 'bold' : '' }}">
                        <td style="border: none"></td>
                        <td style="text-align: center">{{ $i + 1 }}</td>
                        <td>{{ $param->nama }} {{ !$param->is_akreditasi ? '**' : '' }}
                            {{ !$param->is_dapat_diuji ? '***' : '' }}</td>
                        <td>{{ $param->pivot->satuan }}</td>
                        <td>{{ $param->pivot->hasil_uji_pembulatan }}</td>
                        @if ($data->baku_mutu)
                            <td>{{ $param->pivot->baku_mutu }}</td>
                        @else
                            <td>-</td>
                        @endif
                        <td>{{ $param->metode }}</td>
                        {{-- <td>{{ App\Models\TitikPermohonanParameter::getHasil($param->pivot) }}</td> --}}
                        <td>{{ $param->pivot->keterangan }}</td>
                    </tr>
                @endforeach
                @php
                    $alpha++;
                @endphp
            @endforeach
            <tr>
                <td colspan="8">
                    @if ($data->permohonan->is_mandiri)
                        <div style="page-break-inside: avoid">
                            <table cellpadding="1" cellspacing="0" style="margin-bottom: 1rem; width: 100%;">
                                <tr>
                                    <td style="vertical-align: top; width: 10%" rowspan="3">Catatan :</td>
                                    @if (isset($data->peraturan) && !$data->permohonan->is_mandiri)
                                        <td style="width: 90%">*) Baku Mutu sesuai {{ $data->peraturan->nama }}
                                            {{ $data->peraturan->nomor }}
                                        </td>
                                    @endif
                                </tr>
                                <tr>
                                    {{-- <td style="width: 10%"></td> --}}
                                    <td style="width: 90%">**) Parameter belum masuk ruang lingkup akreditasi</td>
                                </tr>
                                <tr>
                                    {{-- <td style="width: 10%"></td> --}}
                                    <td style="width: 90%">***) Parameter termasuk dalam Parameter Subkontrak</td>
                                </tr>
                            </table>

                            <table style="margin-top: 1rem;">
                                <tr>
                                    <td style="opacity: 0; width: 60%">-</td>
                                    <td style="width: 40%; text-align: center">
                                        <div>Jombang, {{ App\Helpers\AppHelper::tanggal_indo($data->getDoneAt()) }}
                                        </div>
                                        <div>{{ $ttd->jabatan }}</div>
                                        @if (isset($tte))
                                            @if (isset($qrCode))
                                                <img src="{{ $qrCode }}"
                                                    style="margin: 2rem 0; width: 80px; height: 80px">
                                            @else
                                                <div style="text-align: center; height: 11rem; line-height: 7rem">
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
                        </div>
                    @endif

                    @if (!$data->permohonan->is_mandiri)
                        <table cellpadding="1" cellspacing="0" style="width: 100%;">
                            <tr>
                                <td style="vertical-align: top; width: 10%">Catatan :</td>
                                @if (isset($data->peraturan) && !$data->permohonan->is_mandiri)
                                    <td style="width: 90%">*) Baku Mutu sesuai {{ $data->peraturan->nama }}
                                        {{ $data->peraturan->nomor }}
                                    </td>
                                @endif
                            </tr>
                        </table>
                        <table cellpadding="1" cellspacing="0" style="width: 100%;">
                            <tr>
                                <td style="width: 10%"></td>
                                <td style="width: 90%">**) Parameter belum masuk ruang lingkup akreditasi</td>
                            </tr>
                        </table>
                        <table cellpadding="1" cellspacing="0" style="margin-bottom: 0rem; width: 100%;">
                            <tr>
                                <td style="width: 10%"></td>
                                <td style="width: 90%">***) Parameter termasuk dalam Parameter Subkontrak</td>
                            </tr>
                        </table>

                        {{-- <div style="page-break-inside: avoid">
                            <table border="0" cellpadding="4" cellspacing="0">
                                <tr>
                                    <td style="vertical-align: top; width: 40px">
                                        <h4 style="margin: 0">IV.</h4>
                                    </td>
                                    <td style="vertical-align: top; width: 30%">
                                        <h4 style="margin: 0">INTERPRETASI HASIL PENGUJIAN</h4>
                                    </td>
                                    <td style="vertical-align: top; width: 20px">:</td>
                                    @if ($data->hasil_pengujian)
                                        @if (isset($data->peraturan))
                                            @if ($data->check())
                                                <td>
                                                    Hasil Analisa Telah Memenuhi sesuai Baku Mutu
                                                    {{ $data->peraturan->nama }}
                                                    {{ $data->peraturan->nomor }}
                                                </td>
                                            @else
                                                <td>
                                                    Hasil Analisa Tidak Memenuhi Baku Mutu {{ $data->peraturan->nama }}
                                                    {{ $data->peraturan->nomor }}
                                                </td>
                                            @endif
                                        @else
                                            @if ($data->check())
                                                <td>Hasil Analisa Telah Memenuhi sesuai Baku Mutu</td>
                                            @else
                                                <td>Hasil Analisa Tidak Memenuhi Baku Mutu</td>
                                            @endif
                                        @endif
                                    @else
                                        <span>-</span>
                                    @endif
                                </tr>
                            </table>

                            <table style="margin-top: 0rem;">
                                <tr>
                                    <td style="opacity: 0; width: 60%">-</td>
                                    <td style="width: 40%; text-align: center">
                                        <div>Jombang, {{ App\Helpers\AppHelper::tanggal_indo($data->getDoneAt()) }}
                                        </div>
                                        <div>{{ $ttd->jabatan }}</div>
                                        @if (isset($tte))
                                            @if (isset($qrCode))
                                                <img src="{{ $qrCode }}"
                                                    style="margin: 1rem 0; width: 80px; height: 80px">
                                            @else
                                                <div style="text-align: center; height: 11rem; line-height: 7rem">
                                                    <span>$</span>
                                                </div>
                                            @endif
                                        @elseif (@$ttd->tanda_tangan)
                                            <img src="{{ public_path($ttd->tanda_tangan) }}" class="ttd">
                                        @else
                                            <br>
                                        @endif
                                        <div>
                                            <strong>{{ $ttd->nama }}</strong>
                                        </div>
                                        <div>NIP. {{ $ttd->nip }}</div>
                                    </td>
                                </tr>
                            </table>
                        </div> --}}
                    @endif
                </td>
            </tr>
            @if (!$data->permohonan->is_mandiri)
                @if ($data->hasil_pengujian)
                    <tr>
                        <td colspan="8">
                            <table cellpadding="1" cellspacing="0">
                                <tr>
                                    <td style="vertical-align: top; width: 40px">
                                        <h4 style="margin: 0">IV.</h4>
                                    </td>
                                    <td style="vertical-align: top; width: 30%">
                                        <h4 style="margin: 0">INTERPRETASI HASIL PENGUJIAN</h4>
                                    </td>
                                    <td style="vertical-align: top; width: 20px">:</td>
                                    @if (isset($data->peraturan))
                                        @if ($data->check())
                                            <td>
                                                Hasil Analisa Telah Memenuhi sesuai Baku Mutu
                                                {{ $data->peraturan->nama }}
                                                {{ $data->peraturan->nomor }}
                                            </td>
                                        @else
                                            <td>
                                                Hasil Analisa Tidak Memenuhi Baku Mutu {{ $data->peraturan->nama }}
                                                {{ $data->peraturan->nomor }}
                                            </td>
                                        @endif
                                    @else
                                        @if ($data->check())
                                            <td>Hasil Analisa Telah Memenuhi sesuai Baku Mutu</td>
                                        @else
                                            <td>Hasil Analisa Tidak Memenuhi Baku Mutu</td>
                                        @endif
                                    @endif
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endif

                <tr>
                    <td colspan="8">
                        <table style="margin-top: 0rem">
                            <tr>
                                <td style="opacity: 0; width: 60%">-</td>
                                <td style="width: 40%; text-align: center">
                                    <div>Jombang, {{ App\Helpers\AppHelper::tanggal_indo($data->getDoneAt()) }}
                                    </div>
                                    <div>{{ $ttd->jabatan }}</div>
                                    @if (isset($tte))
                                        @if (isset($qrCode))
                                            <img src="{{ $qrCode }}"
                                                style="margin: 1rem 0; width: 80px; height: 80px">
                                        @else
                                            <div style="text-align: center; height: 11rem; line-height: 7rem">
                                                <span>$</span>
                                            </div>
                                        @endif
                                    @elseif (@$ttd->tanda_tangan)
                                        <img src="{{ public_path($ttd->tanda_tangan) }}" class="ttd">
                                    @else
                                        <br>
                                    @endif
                                    <div>
                                        <strong>{{ $ttd->nama }}</strong>
                                    </div>
                                    <div>NIP. {{ $ttd->nip }}</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</body>

{{-- <script>
    window.parent.postMessage("TEST MESSAGE", "*");
</script> --}}

</html>
