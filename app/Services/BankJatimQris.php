<?php

namespace App\Services;

use App\Models\KodeRetribusi;
use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BankJatimQris {
  private $url;
  private $client;

  public function __construct() {
    $this->url = env('QRIS_URL');
    $this->client = new \GuzzleHttp\Client([
      'base_uri' => $this->url,
    ]);
  }

  public function createQR(Payment $payment) {
    $body = [
      "merchantPan" => env('QRIS_MERCHANT_PAN'),
      "hashcodeKey" => hash('sha256', env('QRIS_MERCHANT_PAN') . $payment->qris_number . env('QRIS_TERMINAL_USER') . env('QRIS_MERCHANT_HASHKEY')),
      "billNumber" => $payment->qris_number,
      "purposetrx" => $payment->kodeRetribusi->kode,
      "storelabel" => env("QRIS_STORE_LABEL"),
      "customerlabel" => env("QRIS_CUSTOMER_LABEL"),
      "terminalUser" => env("QRIS_TERMINAL_USER"),
      "expiredDate" => $payment->qris_expired,
      "amount" => $payment->jumlah
    ];

    // $response = $this->client->post('/MC/Qris/Dynamic', [
    //   'json' => $body,
    //   'headers' => [
    //     'Content-Type' => 'application/json',
    //     'Accept' => 'application/json',
    //     'User-Agent' => 'SILAJANG/' . date('Y')
    //   ]
    // ]);

    $response = Http::post($this->url . '/MC/Qris/Dynamic', $body);

    Log::info($body);

    return $response;

    // $response = json_decode($response->body(), true);

    if ($response->ok()) {
      return ['status' => true];
    } else {
      return $response;
    }
    return $response;
    // dd($response);
    // return !$response['Status']['IsError'];
  }
}
