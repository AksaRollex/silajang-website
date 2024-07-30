<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>SKRD</title>
    <style>
        :root {
            font-size: 12px;
        }

        body {
            font-family: Times New Roman, serif;
            margin: 0px;
            padding: 0px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 0;
        }

        .heading * {
            font-family: Arial, Helvetica, sans-serif;
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

        .italic * {
            font-style: italic;
        }

        .ttd {
            width: 150px;
            height: 100px;
            object-fit: contain;
        }

        ul.check {
            list-style: none;
        }

        ul.check li:before {
            content: '✓';
        }

        footer.tte {
            position: fixed;
            bottom: -2rem;
            left: 0px;
            right: 0px;
            text-align: center;
        }
    </style>
</head>

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

    <table class="main" border="0" cellpadding="4" cellspacing="0">
        <tr>
            <td style="opacity: 0; width: calc(40% / 7)">-</td>
            <td style="opacity: 0; width: calc(40% / 7)">-</td>
            <td style="opacity: 0; width: calc(40% / 7)">-</td>
            <td style="opacity: 0; width: calc(40% / 7)">-</td>
            <td style="opacity: 0; width: calc(40% / 7)">-</td>
            <td style="opacity: 0; width: calc(40% / 7)">-</td>
            <td style="opacity: 0; width: calc(40% / 7)">-</td>
            <td style="opacity: 0; width: 10%">-</td>
            <td style="opacity: 0; width: 25%">-</td>
            <td style="opacity: 0; width: 25%">-</td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: center">
                <h3 style="font-weight: 700">PEMERINTAH KABUPATEN JOMBANG</h3>
                <h4 style="font-weight: 400">DINAS LINGKUNGAN HIDUP UPT LABORATORIUM LINGKUNGAN</h4>
                <h6 style="font-weight: 400">JL. KH. ABUDURRACHMAN WACHID NO. 152, CANDIMULYO, JOMBANG</h6>
            </td>
            <td colspan="2">
                <h1 style="font-weight: 700; text-align: center">SKRD</h1>
                <h4 style="font-weight: 400; text-align: center">(SURAT KETETAPAN RETRIBUASI DAERAH)</h4>

                <br>
                <div>MASA RETRIBUSI:
                    {{ App\Helpers\AppHelper::tanggal_indo(Carbon\Carbon::parse($data->payment->created_at)->format('Y-m-d')) }}
                    s/d
                    {{ App\Helpers\AppHelper::tanggal_indo(Carbon\Carbon::parse($data->payment->tanggal_exp)->format('Y-m-d')) }}
                </div>
                <div>TAHUN RETRIBUSI: {{ Carbon\Carbon::parse($data->payment->created_at)->format('Y') }}</div>
            </td>
            <td>
                <h4 style="font-weight: 400; text-align: center">NO. URUT</h4>
                <h4 style="font-weight: 400; text-align: center">{{ $data->payment->kode }}</h4>
            </td>
        </tr>
        <tr>
            <td colspan="7" style="border: 0; border-left: 2px solid #000; border-right: 2px solid #000">NAMA</td>
            <td colspan="3" style="border: 0; border-right: 2px solid #000">
                <span>:</span>
                <span>{{ $data->permohonan->user->nama }}</span>
            </td>
        </tr>
        <tr>
            <td colspan="7" style="border: 0; border-left: 2px solid #000; border-right: 2px solid #000">ALAMAT</td>
            <td colspan="3" style="border: 0; border-right: 2px solid #000">
                <span>:</span>
                <span>{{ $data->permohonan->user->detail->alamat }}</span>
            </td>
        </tr>
        {{-- <tr>
            <td colspan="7" style="border: 0; border-left: 2px solid #000; border-right: 2px solid #000">NPWP/NPWPD
            </td>
            <td colspan="3" style="border: 0; border-right: 2px solid #000">
                <span>:</span>
                <span>{{ $data->permohonan->user->detail->npwp }}</span>
            </td>
        </tr> --}}
        <tr>
            <td colspan="7" style="border: 0; border-left: 2px solid #000; border-right: 2px solid #000">JATUH TEMPO
            </td>
            <td colspan="3" style="border: 0; border-right: 2px solid #000">
                <span>:</span>
                <span>{{ App\Helpers\AppHelper::tanggal_indo(Carbon\Carbon::parse($data->payment->tanggal_exp)->format('Y-m-d')) }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <h4>NO</h4>
            </td>
            <td colspan="6">
                <h4>KODE REKENING</h4>
            </td>
            <td colspan="2">
                <h4>JENIS RETRIBUSI</h4>
            </td>
            <td>
                <h4>JUMLAH</h4>
            </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="6">
                4.1.02.02.01.0004
            </td>
            <td colspan="2">
                <div>
                    Pengujian : {{ @$data->jenis_sampel->nama }}
                </div>
                <div>
                    Parameter Pengujian : {{ $data->parameters->pluck('nama')->join(', ') }}
                </div>
                <div>
                    Biaya Pengambilan :
                    @php
                        $biaya = 0;
                        if ($data->permohonan->jasaPengambilan) {
                            $biaya += $data->permohonan->jasaPengambilan->harga;
                        }
                        if ($data->permohonan->radiusPengambilan) {
                            $biaya += $data->permohonan->radiusPengambilan->harga;
                        }
                    @endphp
                    {{ App\Helpers\AppHelper::rupiah($biaya) }}
                </div>
                <br>
                <div>
                    Denda Retribusi :
                </div>
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="9">
                <h3 style="font-weight: 700; text-align: center">JUMLAH KETETAPAN</h3>
            </td>
            <td>
                {{ App\Helpers\AppHelper::rupiah($biaya + $data->harga) }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="vertical-align: top; border-right: 0">
                Terbilang :
            </td>
            <td colspan="8" style="vertical-align: top; border-left: 0">
                {{ App\Helpers\AppHelper::AngkaToText($biaya + $data->harga) }} Rupiah
            </td>
        </tr>
        <tr>
            <td colspan="2" style="vertical-align: top; border-right: 0">
                Perhatian :
            </td>
            <td colspan="8" style="vertical-align: top; border-left: 0">
                <ol style="padding: 0 0 0 1rem; margin: 0">
                    <li>
                        Harap pembayaran dilakukan secara non tunai dengan melakukan pembayaran ke rekening Bank Jatim
                        Dinas Lingkungan Hidup sesuai dengan kode Virtual Account : {{ $data->payment->va_number }}
                    </li>
                    <li>
                        Apabila SKRD ini tidak dibayarkan atau kurang bayar setelah lewat waktu paling lama 30 hari
                        sejak SKRD ini diterima dikenakan sanksi administrasi berupa Bunga sebesar 2% per bulan.
                    </li>
                </ol>
            </td>
        </tr>
        <tr>
            <td style="border-right: 0" colspan="8">-</td>
            <td style="border-left: 0; text-align: center" colspan="2">
                <div>Jombang, {{ App\Helpers\AppHelper::tanggal_indo(date('Y-m-d')) }}</div>
                <div>{{ $ttdUPT->jabatan }}</div>
                @if ($tte)
                    @if (isset($qrCode))
                        <img src="{{ $qrCode }}" style="margin: 2rem 0">
                    @else
                        <div style="text-align: center; height: 15rem; line-height: 10rem">
                            <span>$</span>
                        </div>
                    @endif
                @elseif (@$ttdUPT->tanda_tangan)
                    <img src="{{ public_path($ttdUPT->tanda_tangan) }}" class="ttd">
                @else
                    <br><br><br><br><br><br>
                @endif
                <div>
                    <strong>{{ $ttdUPT->nama }}</strong>
                </div>
                <div>NIP. {{ $ttdUPT->nip }}</div>
            </td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: center">
                <div>Pelanggan</div>
                <br><br><br><br><br><br>
                <div>
                    <strong>{{ $data->permohonan->user->nama }}</strong>
                </div>
            </td>
            <td colspan="2" style="text-align: center">
                <div>{{ $ttdBayar->jabatan }}</div>
                @if (@$ttdBayar->tanda_tangan)
                    <img src="{{ public_path($ttdBayar->tanda_tangan) }}" class="ttd">
                @else
                    <br><br><br><br><br><br>
                @endif
                <div>
                    <strong>{{ $ttdBayar->nama }}</strong>
                </div>
                <div>NIP. {{ $ttdBayar->nip }}</div>
            </td>
        </tr>
    </table>

    {{-- <table style="margin-top: 2rem; page-break-inside: avoid">
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
    </table> --}}

</body>

</html>
