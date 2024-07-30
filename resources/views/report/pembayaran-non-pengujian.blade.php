<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pembayaran Non Pengujian</title>
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
</style>

<body>
    <footer style="padding: 0.5rem; text-align: left">
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
                <h2 style="margin: 0;">PEMBAYARAN NON PENGUJIAN</h2>
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

    <br><br>

    <table class="main" cellpadding="6" cellspacing="0">
        <tr>
            <th style="text-align: center">No.</th>
            <th style="text-align: center; width: 120">Virtual Account</th>
            <th style="text-align: center">Nama</th>
            <th style="text-align: center">Jumlah/Nominal</th>
            <th style="text-align: center">Tanggal Kedaluwarsa</th>
            <th style="text-align: center">Status</th>
        </tr>

        @foreach ($data as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->va_number }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ App\Helpers\AppHelper::rupiah($item->jumlah) }}</td>
                <td>{{ App\Helpers\AppHelper::tanggal_indo($item->tanggal_exp) }}</td>
                @if ($item->is_expired)
                    <td>Kedaluwarsa</td>
                @else
                    <td>{{ ucfirst($item->status) }}</td>
                @endif
            </tr>
        @endforeach
    </table>
</body>

</html>
