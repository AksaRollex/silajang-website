<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\KodeRetribusi;
use App\Models\LogBankJatim;
use App\Models\Payment;
use App\Models\TrackingPengujian;
use App\Services\BankJatim;
use App\Services\BankJatimQris;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller // Pembayaran utk Non Pengujian
{
  public function post(Request $request) {
    Log::info("=== POST PAYMENT ===");
    Log::info($request->all());

    $request->validate([
      'VirtualAccount' => 'required',
      'Amount' => 'required',
      'Tanggal' => 'required',
    ]);

    $payment = Payment::where('va_number', $request->VirtualAccount)->where('jumlah', $request->Amount)->first();

    if (!$payment) {
      return response()->json([
        'VirtualAccount' => $request->VirtualAccount,
        'Amount' => $request->Amount,
        'Tanggal' => $request->Tanggal,
        'Status' => [
          "IsError" => "True",
          "ResponseCode" => "01",
          "ErrorDesc" => "Data tidak ditemukan"
        ]
      ]);
    }

    if ($payment) {
      $payment->update([
        'status' => 'success',
        'is_lunas' => 1,
        'tanggal_bayar' => date('Y-m-d')
      ]);

      if ($payment->multiPayments->count() > 0) {
        foreach ($payment->multiPayments as $item) {
          $item->titikPermohonan->update([
            'status_pembayaran' => 1
          ]);

          if ($item->titikPermohonan->status == 8) {
            $item->titikPermohonan->update([
              'status' => 9,
            ]);

            TrackingPengujian::create([
              'titik_permohonan_id' => $item->titik_permohonan_id,
              'status' => 9,
            ]);
          }
        }
      } else {
        if ($payment->titikPermohonan) {
          $payment->titikPermohonan->update([
            'status_pembayaran' => 1
          ]);

          if ($payment->titikPermohonan->status == 8) {
            $payment->titikPermohonan->update([
              'status' => 9,
            ]);

            TrackingPengujian::create([
              'titik_permohonan_id' => $payment->titik_permohonan_id,
              'status' => 9,
            ]);
          }
        }
      }
    }

    return response()->json([
      'VirtualAccount' => $request->VirtualAccount,
      'Amount' => $request->Amount,
      'Tanggal' => $request->Tanggal,
      'Status' => [
        "IsError" => "False",
        "ResponseCode" => "00",
        "ErrorDesc" => "Success"
      ]
    ]);
  }

  public function get() {
    return response()->json([
      'message' => 'Data berhasil ditemukan',
      'data' => Payment::get()
    ]);
  }

  public function index(Request $request) {
    if (request()->wantsJson()) {
      $per = (($request->per) ? $request->per : 10);
      $page = (($request->page) ? $request->page - 1 : 0);

      DB::statement('set @no=0+' . $page * $per);
      $data = Payment::where(function ($q) use ($request) {
        $q->where('va_number', 'LIKE', '%' . $request->search . '%');
        $q->orWhere('nama', 'LIKE', '%' . $request->search . '%');
        $q->orWhere('jumlah', 'LIKE', '%' . $request->search . '%');
        $q->orWhere('tanggal_exp', 'LIKE', '%' . $request->search . '%');
      })->where('titik_permohonan_id', null)->whereDoesntHave('multiPayments')->where('status', '!=', 'failed')->orderBy('created_at', 'desc')->whereYear('created_at', $request->tahun)->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);
      // })->where('type', $request->type)->where('titik_permohonan_id', null)->whereDoesntHave('multiPayments')->where('status', '!=', 'failed')->orderBy('created_at', 'desc')->whereYear('created_at', $request->tahun)->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

      $data->map(function ($a) {
        if ($a->type == 'va') {
          $a->tanggal_exp_indo = $a->tanggal_exp ? AppHelper::tanggal_indo($a->tanggal_exp) : '-';
        } else {
          $a->tanggal_exp_indo = $a->qris_expired ? AppHelper::tanggal_indo(Carbon::parse($a->qris_expired)->format('Y-m-d')) : '-';
        }
      });

      return response()->json($data);
    } else {
      return abort(404);
    }
  }

  public function store(Request $request) {
    $data = $this->validate($request, [
      'type' => 'required',
      'nama' => 'required',
      'jumlah' => 'required',
      'tanggal_exp' => 'required',
      'kode_retribusi_id' => 'required',
      'berita1' => 'nullable',
      'berita2' => 'nullable',
      'berita3' => 'nullable',
      'berita4' => 'nullable',
      'berita5' => 'nullable',
    ]);

    $kodeRet = KodeRetribusi::find($request->kode_retribusi_id);
    $bankJatim = new BankJatim();
    $bankJatimQris = new BankJatimQris();

    if ($data['type'] == 'va') {
      $data['va_number'] = $bankJatim->getVA($kodeRet);
    } else {
      $data['qris_number'] = time() . rand(1000, 9999);
    }

    $data['jumlah'] = str_replace('.', '', $data['jumlah']);
    $data['jumlah'] = str_replace(',', '.', $data['jumlah']);

    if ($data['type'] == 'qris') {
      $data['qris_expired'] = $data['tanggal_exp'] . ' 23:59:59';
      unset($data['tanggal_exp']);
    } else {
      unset($data['qris_expired']);
    }

    $response = '';

    if ($payment = Payment::create($data)) {
      $payment->genKode();

      if ($payment->type == 'va') {
        try {
          $response = $bankJatim->registerVA($payment);
          if (!@$response['status']) {
            Log::info([
              'va_number' => $data['va_number'],
              'status' => 'error',
              // 'status' => 'success',
              'message' => json_encode($response),
              'ip_address' => $request->ip(),
              'user_agent' => $request->userAgent(),
              'created_at' => date('Y-m-d H:i:s')
            ]);

            $payment->delete();
            return response()->json([
              'message' => 'VA pembayaran gagal dibuat. Silahkan coba lagi.',
            ], 500);
          }
        } catch (\Throwable $th) {
          log::info([
            'va_number' => $data['va_number'],
            'status' => 'error',
            // 'status' => 'success',
            'message' => json_encode($th->getMessage()),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => date('Y-m-d H:i:s')
          ]);

          $payment->delete();
          return response()->json([
            'message' => 'VA pembayaran gagal dibuat. Silahkan coba lagi.',
          ], 500);
        }
      } else if ($payment->type == 'qris') {
        try {
          $response = $bankJatimQris->createQR($payment);
          if ($response->failed()) {
            Log::info([
              'qris_number' => $data['qris_number'],
              'status' => 'error',
              // 'status' => 'success',
              'message' => json_encode($response->body()),
              'ip_address' => $request->ip(),
              'user_agent' => $request->userAgent(),
              'created_at' => date('Y-m-d H:i:s')
            ]);

            $payment->delete();
            return response()->json([
              'message' => 'QRIS gagal dibuat. Silahkan coba lagi.',
            ], 500);
          }
        } catch (\Throwable $th) {
          Log::info([
            'qris_number' => $data['qris_number'],
            'status' => 'error',
            // 'status' => 'success',
            'message' => json_encode($response->body()),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => date('Y-m-d H:i:s')
          ]);

          $payment->delete();
          return response()->json([
            'message' => 'QRIS gagal dibuat. Silahkan coba lagi.',
          ], 500);
        }

        $payment->update([
          'qris_value' => $response->collect('qrValue')->first()
        ]);
      }

      return response()->json([
        'message' => 'Data berhasil disimpan.',
        'data' => $payment
      ]);
    }
  }

  public function edit($uuid) {
    $payment = Payment::findByUuid($uuid);
    if ($payment->type == 'qris') {
      $payment->tanggal_exp = $payment->qris_expired;
    }
    return response()->json([
      'data' => $payment
    ]);
  }

  public function destroy($uuid) {
    $payment = Payment::findByUuid($uuid);
    if ($payment->update(['status' => 'failed'])) {
      return response()->json([
        'message' => 'Data berhasil dihapus.',
      ]);
    }
  }
}
