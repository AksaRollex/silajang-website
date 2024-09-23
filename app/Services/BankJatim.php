<?php

namespace App\Services;

use App\Models\KodeRetribusi;
use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BankJatim {
  private $url;
  private $kode;
  private $client;

  /*
    VA NUMBER EG: 1494022023083101

    1494 = Kode Bank Jatim
    02 = Kode Retribusi
    20230831 = Tanggal
    01 = Nomor Urut
    */

  public function __construct() {
    $this->url = env('BANK_JATIM_URL');
    $this->kode = env('BANK_JATIM_KODE');
    $this->client = new \GuzzleHttp\Client([
      'base_uri' => $this->url,
    ]);
  }

  private function genNoUrut() // Nomor Urut by VA
  {
    $last = Payment::where('va_number', 'LIKE', $this->kode . '%')->whereDate('created_at', date(('Y-m-d')))->orderBy('va_number', 'DESC')->first();
    if ($last) {
      $last = substr($last->va_number, -2);
      $last = (int) $last;
      $last++;
    } else {
      $last = 1;
    }

    $last = str_pad($last, 2, '0', STR_PAD_LEFT);

    return $last;
  }

  public function getVA(KodeRetribusi $kodeRet) {
    $kode = $this->kode;
    $kode .= $kodeRet->kode;
    $kode .= date('Ymd');
    $kode .= $this->genNoUrut();

    return $kode;
  }

  public function registerVA(Payment $payment) {
    $body = [
      'VirtualAccount' => $payment->va_number,
      'Nama' => $payment->nama,
      'TotalTagihan' => $payment->jumlah,
      'TanggalExp' => Carbon::parse($payment->tanggal_exp)->format('Ymd'),
      'Berita1' => $payment->berita1 ?? "",
      'Berita2' => $payment->berita2 ?? "",
      'Berita3' => $payment->berita3 ?? "",
      'Berita4' => $payment->berita4 ?? "",
      'Berita5' => $payment->berita5 ?? "",
      'FlagProses' => 1,
    ];

    Log::info($body);

    $response = $this->client->post('Va/RegPen', [
      'json' => $body
    ]);

    $response = json_decode($response->getBody()->getContents(), true);

    if (!$response['Status']['IsError']) {
      return ['status' => true];
    } else {
      return $response;
    }
    return $response;
    // dd($response);
    // return !$response['Status']['IsError'];
  }

  public function checkStatus(Payment $payment) {
    $response = $this->client->post("Va/CheckStatus", [
      'json' => [
        'VirtualAccount' => $payment->va_number,
      ]
    ]);

    $response = json_decode($response->getBody()->getContents(), true);

    return $response['FlagLunas'] == 'Y';
  }
}
