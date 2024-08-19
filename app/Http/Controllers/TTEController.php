<?php

namespace App\Http\Controllers;

use App\Helpers\TTEHelper;
use App\Models\TandaTangan;
use App\Models\TitikPermohonan;
use Carbon\Carbon;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TTEController extends Controller {
  public function postLhu(Request $request, $uuid) {
    $request->validate([
      'tanda_tangan_id' => 'required|numeric',
      'passphrase' => 'required|string',
      'tipe' => 'required|string',
    ]);

    $data = TitikPermohonan::findByUuid($uuid);
    $ttd = TandaTangan::find($request->tanda_tangan_id);

    if (!file_exists(storage_path('app/private/qrcode'))) {
      mkdir(storage_path('app/private/qrcode'), 0777, true);
    }

    $qrname = ($ttd->nip . ' ' . time());
    $qrCode = QrCode::size(200)->format('png')->merge("/public/media/logo-jombang.png", .2)->generate(($ttd->nip . ' ' . date('Y-m-d H:i:s')) ?? '', storage_path('app/private/qrcode/' . $qrname . '.png'));
    $qrCode = fopen(storage_path('app/private/qrcode/' . $qrname . '.png'), 'r');

    $sertifikat = new ReportController();

    $filename = 'LAPORAN-HASIL-PENGUJIAN-' . str_replace('/', '_', $data->kode) . '.pdf';

    if ($request->tipe == "system") {
      $file = $sertifikat->reportLHU($request, $uuid, false, true, true);
    } else if ($request->tipe == "manual") {
      $file = fopen(storage_path('app/private/' . $data->file_lhu), 'r');
    }

    try {
      $tte = new TTEHelper();
      $response = $tte->post($file, $qrCode, $ttd->nik, base64_decode($request->passphrase));

      if ($response) {
        if (str_contains($response, 'error')) {
          $response = json_decode($response, true);

          $data->logTtes()->create([
            'nik' => $ttd->nik,
            'status' => 'error',
            'message' => $response['error'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => date('Y-m-d H:i:s')
          ]);

          unlink(storage_path('app/private/lhu/' . $filename));

          $data->update(['status_tte' => 0]);

          $request->merge(['response' => $response]);
          return $sertifikat->reportError($request);
        }

        $data->logTtes()->create([
          'nik' => $ttd->nik,
          'status' => 'success',
          'message' => 'TTE LHU',
          'ip_address' => $request->ip(),
          'user_agent' => $request->userAgent(),
          'created_at' => date('Y-m-d H:i:s')
        ]);

        Storage::put('private/lhu/' . $filename, $response);

        $data->update(['status_tte' => 1]);
        $data->update(['tanggal_tte' => Carbon::now()]);

        return response($response, 200, ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'inline; filename="' . $filename . '"']);
      }
    } catch (\Throwable $th) {
      $data->logTtes()->create([
        'nik' => $ttd->nik,
        'status' => 'error',
        // 'status' => 'success',
        'message' => json_encode($th->getMessage()),
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'created_at' => date('Y-m-d H:i:s')
      ]);

      $data->update(['status_tte' => 0]);

      if ($request->tipe == "system") {
        unlink(storage_path('app/private/lhu/' . $filename));
      }

      $request->merge(['qrCode' => storage_path('app/private/qrcode/' . $ttd->nik . '.png')]);
      return $sertifikat->reportLHU($request, $uuid, false, true);
    }
    // return response()->download(storage_path('app/private/lhu/' . $filename), $filename, ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'inline; filename="' . $filename . '"']);
  }

  public function downloadLhu($uuid) {
    $data = TitikPermohonan::findByUuid($uuid);
    return response()->file($data->tte_lhu);
  }

  public function postSKRD(Request $request, $uuid) {
    $request->validate([
      'tanda_tangan_id' => 'required|numeric',
      'passphrase' => 'required|string',
    ]);

    $data = TitikPermohonan::findByUuid($uuid);
    $ttd = TandaTangan::find($request->tanda_tangan_id);

    if (!file_exists(storage_path('app/private/qrcode'))) {
      mkdir(storage_path('app/private/qrcode'), 0777, true);
    }

    $qrCode = QrCode::size(200)->format('png')->merge("/public/media/logo-jombang.png", .2)->generate(($ttd->nip . ' ' . date('Y-m-d H:i:s')) ?? '', storage_path('app/private/qrcode/' . ($ttd->nip . ' ' . date('Y-m-d H:i:s')) . '.png'));
    $qrCode = fopen(storage_path('app/private/qrcode/' . ($ttd->nip . ' ' . date('Y-m-d H:i:s')) . '.png'), 'r');

    $sertifikat = new ReportController();

    $filename = 'SKRD-' . str_replace('/', '_', $data->kode) . '.pdf';
    $file = $sertifikat->reportSKRD($request, $uuid, true, true);

    try {
      $tte = new TTEHelper();
      $response = $tte->post($file, $qrCode, $ttd->nik, base64_decode($request->passphrase));

      if ($response) {
        if (str_contains($response, 'error')) {
          $response = json_decode($response, true);

          $data->logTtes()->create([
            'nik' => $ttd->nik,
            'status' => 'error',
            'message' => $response['error'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => date('Y-m-d H:i:s')
          ]);

          unlink(storage_path('app/private/skrd/' . $filename));

          $data->update(['status_tte' => 0]);

          $request->merge(['response' => $response]);
          return $sertifikat->reportError($request);
        }

        $data->logTtes()->create([
          'nik' => $ttd->nik,
          'status' => 'success',
          'message' => 'TTE SKRD',
          'ip_address' => $request->ip(),
          'user_agent' => $request->userAgent(),
          'created_at' => date('Y-m-d H:i:s')
        ]);

        Storage::put('private/skrd/' . $filename, $response);

        $data->update(['status_tte_skrd' => 1]);

        return response($response, 200, ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'inline; filename="' . $filename . '"']);
      }
    } catch (\Throwable $th) {
      $data->logTtes()->create([
        'nik' => $ttd->nik,
        'status' => 'error',
        // 'status' => 'success',
        'message' => json_encode($th->getMessage()),
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'created_at' => date('Y-m-d H:i:s')
      ]);

      unlink(storage_path('app/private/skrd/' . $filename));

      $data->update(['status_tte_skrd' => 0]);

      $request->merge(['qrCode' => storage_path('app/private/qrcode/' . $ttd->nik . '.png')]);
      return $sertifikat->reportSKRD($request, $uuid, true);
    }

    // return response()->download(storage_path('app/private/skrd/' . $filename), $filename, ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'inline; filename="' . $filename . '"']);
  }

  public function downloadSKRD($uuid) {
    $data = TitikPermohonan::findByUuid($uuid);
    return response()->file($data->tte_skrd);
  }

  public function postKendaliMutu(Request $request, $uuid) {
    $request->validate([
      'tanda_tangan_id' => 'required|numeric',
      'passphrase' => 'required|string',
    ]);

    $data = TitikPermohonan::findByUuid($uuid);
    $ttd = TandaTangan::find($request->tanda_tangan_id);

    if (!file_exists(storage_path('app/private/qrcode'))) {
      mkdir(storage_path('app/private/qrcode'), 0777, true);
    }

    $qrCode = QrCode::size(200)->format('png')->merge("/public/media/logo-jombang.png", .2)->generate(($ttd->nip . ' ' . date('Y-m-d H:i:s')) ?? '', storage_path('app/private/qrcode/' . ($ttd->nip . ' ' . date('Y-m-d H:i:s')) . '.png'));
    $qrCode = fopen(storage_path('app/private/qrcode/' . ($ttd->nip . ' ' . date('Y-m-d H:i:s')) . '.png'), 'r');

    $sertifikat = new ReportController();

    $filename = 'Kendali-Mutu-' . str_replace('/', '_', $data->no_formulir) . '.pdf';
    $file = $sertifikat->reportKendaliMutu($request, $uuid, true, true);

    try {
      $tte = new TTEHelper();
      $response = $tte->post($file, $qrCode, $ttd->nik, base64_decode($request->passphrase));

      if ($response) {
        if (str_contains($response, 'error')) {
          $response = json_decode($response, true);

          $data->logTtes()->create([
            'nik' => $ttd->nik,
            'status' => 'error',
            'message' => $response['error'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => date('Y-m-d H:i:s')
          ]);

          unlink(storage_path('app/private/kendali-mutu/' . $filename));

          $data->update(['status_tte' => 0]);

          $request->merge(['response' => $response]);
          return $sertifikat->reportError($request);
        }

        $data->logTtes()->create([
          'nik' => $ttd->nik,
          'status' => 'success',
          'message' => 'TTE Kendali Mutu',
          'ip_address' => $request->ip(),
          'user_agent' => $request->userAgent(),
          'created_at' => date('Y-m-d H:i:s')
        ]);

        Storage::put('private/kendali-mutu/' . $filename, $response);

        $data->update(['status_tte_kendali_mutu' => 1]);

        return response($response, 200, ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'inline; filename="' . $filename . '"']);
      }
    } catch (\Throwable $th) {
      $data->logTtes()->create([
        'nik' => $ttd->nik,
        'status' => 'error',
        // 'status' => 'success',
        'message' => json_encode($th->getMessage()),
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'created_at' => date('Y-m-d H:i:s')
      ]);

      unlink(storage_path('app/private/kendali-mutu/' . $filename));

      $data->update(['status_tte_kendali_mutu' => 0]);

      $request->merge(['qrCode' => storage_path('app/private/qrcode/' . $ttd->nik . '.png')]);
      return $sertifikat->reportKendaliMutu($request, $uuid, true);
    }
    // return response()->download(storage_path('app/private/kendali-mutu/' . $filename), $filename, ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'inline; filename="' . $filename . '"']);
  }

  public function downloadKendaliMutu($uuid) {
    $data = TitikPermohonan::findByUuid($uuid);
    return response()->file($data->tte_kendali_mutu);
  }

  public function postKwitansi(Request $request, $uuid) {
    $request->validate([
      'tanda_tangan_id' => 'required|numeric',
      'passphrase' => 'required|string',
    ]);

    $data = TitikPermohonan::findByUuid($uuid);
    $ttd = TandaTangan::find($request->tanda_tangan_id);

    if (!file_exists(storage_path('app/private/qrcode'))) {
      mkdir(storage_path('app/private/qrcode'), 0777, true);
    }

    $qrCode = QrCode::size(200)->format('png')->merge("/public/media/logo-jombang.png", .2)->generate(($ttd->nip . ' ' . date('Y-m-d H:i:s')) ?? '', storage_path('app/private/qrcode/' . ($ttd->nip . ' ' . date('Y-m-d H:i:s')) . '.png'));
    $qrCode = fopen(storage_path('app/private/qrcode/' . ($ttd->nip . ' ' . date('Y-m-d H:i:s')) . '.png'), 'r');

    $sertifikat = new ReportController();

    $filename = 'Kwitansi-' . str_replace('/', '_', $data->kode) . '.pdf';
    $file = $sertifikat->reportKwitansi($request, $uuid, true, true);


    try {
      $tte = new TTEHelper();
      $response = $tte->post($file, $qrCode, $ttd->nik, base64_decode($request->passphrase));

      if ($response) {
        if (str_contains($response, 'error')) {
          $response = json_decode($response, true);

          $data->logTtes()->create([
            'nik' => $ttd->nik,
            'status' => 'error',
            'message' => $response['error'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => date('Y-m-d H:i:s')
          ]);

          unlink(storage_path('app/private/kwitansi/' . $filename));

          $data->update(['status_tte' => 0]);

          $request->merge(['response' => $response]);
          return $sertifikat->reportError($request);
        }

        $data->logTtes()->create([
          'nik' => $ttd->nik,
          'status' => 'success',
          'message' => 'TTE Kwitansi',
          'ip_address' => $request->ip(),
          'user_agent' => $request->userAgent(),
          'created_at' => date('Y-m-d H:i:s')
        ]);

        Storage::put('private/kwitansi/' . $filename, $response);

        $data->update(['status_tte_kwitansi' => 1]);

        return response($response, 200, ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'inline; filename="' . $filename . '"']);
      }
    } catch (\Throwable $th) {
      $data->logTtes()->create([
        'nik' => $ttd->nik,
        'status' => 'error',
        // 'status' => 'success',
        'message' => json_encode($th->getMessage()),
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'created_at' => date('Y-m-d H:i:s')
      ]);

      unlink(storage_path('app/private/kwitansi/' . $filename));

      $data->update(['status_tte_kwitansi' => 1]);

      $request->merge(['qrCode' => storage_path('app/private/qrcode/' . $ttd->nik . '.png')]);
      return $sertifikat->reportKwitansi($request, $uuid, true);
    }

    // return response()->download(storage_path('app/private/kendali-mutu/' . $filename), $filename, ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'inline; filename="' . $filename . '"']);
  }

  public function downloadKwitansi($uuid) {
    $data = TitikPermohonan::findByUuid($uuid);
    return response()->file($data->tte_kwitansi);
  }
}
