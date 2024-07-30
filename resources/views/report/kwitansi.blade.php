<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Bukti Pembayaran {{ $data->no_formulir }}</title>
    <style>
        :root {
            font-size: 16px;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0px;
            padding: 0px;
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

    <table class="heading" style="margin-bottom: 2rem">
        <tr>
            <td style="text-align: center;">
                <h3 style="margin: 0;">PEMERINTAH KABUPATEN JOMBANG</h3>
                <h3 style="margin: 0;">DINAS LINGKUNGAN HIDUP KABUPATEN JOMBANG</h3>
                <h3 style="margin: 0;">UPT LABORATORIUM LINGKUNGAN KABUPATEN JOMBANG</h3>
            </td>
        </tr>
    </table>

    <h1 style="text-decoration: underline; text-align: center; margin: 0; font-weight: 400">KWITANSI</h1>

    <br>

    <table border="0" cellpadding="4" cellspacing="0">
        <tr>
            <td style="width: 30%">
                <div>Sudah diterima dari</div>
            </td>
            <td style="width: 20px; text-align: center">:</td>
            <td>{{ $data->permohonan->user->nama }} / {{ $data->permohonan->user->detail->instansi }}</td>
        </tr>
        <tr>
            <td style="width: 30%">
                <div>Buat Pembayaran</div>
            </td>
            <td style="width: 20px; text-align: center">:</td>
            <td>Pengujian Laboratorium untuk Sampel dengan Kode {{ $data->kode }}</td>
        </tr>
    </table>

    <table style="margin-top: 2rem; page-break-inside: avoid">
        <tr>
            <td style="width: 60%; vertical-align: top">
                <div>
                    <em>Terbilang {{ App\Helpers\AppHelper::AngkaToText($data->payment->jumlah) }} Rupiah</em>
                </div>
                <span
                    style="display: inline-block; margin-top: 1rem; padding: 0.5rem; border: 1px solid #000">{{ App\Helpers\AppHelper::rupiah($data->payment->jumlah) }}</span>
            </td>
            <td style="width: 40%; text-align: center">
                <div>Jombang, {{ App\Helpers\AppHelper::tanggal_indo($data->payment->tanggal_bayar ?? date('Y-m-d')) }}
                </div>
                <div>Yang Menerima</div>
                <div>UPT Laboratorium Lingkungan</div>
                <div>DLH Kab. Jombang</div>
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
