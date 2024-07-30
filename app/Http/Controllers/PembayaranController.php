<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\KodeRetribusi;
use App\Models\Payment;
use App\Models\TitikPermohonan;
use App\Models\TrackingPengujian;
use App\Services\BankJatim;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PembayaranController extends Controller // Pembayaran utk Pengujian
{
  private function checkExpired() {
    $payments = Payment::where('status', 'pending')->get();
    foreach ($payments as $payment) {
      if ($payment->is_expired) {
        // $payment->update([
        //     'status' => 'failed'
        // ]);

        if (isset($payment->titik_permohonan_id)) {
          $payment->titikPermohonan->update([
            'status_pembayaran' => 2
          ]);
        }
      }
    }
  }

  public function index(Request $request) {
    if (request()->wantsJson()) {
      $this->checkExpired();

      $per = (($request->per) ? $request->per : 10);
      $page = (($request->page) ? $request->page - 1 : 0);

      DB::statement('set @no=0+' . $page * $per);
      $data = TitikPermohonan::with(['permohonan.user', 'payment'])->where(function ($q) use ($request) {
        $q->where('kode', 'LIKE', '%' . $request->search . '%');
        $q->orWhere('lokasi', 'LIKE', '%' . $request->search . '%');
      })->when(auth()->user()->hasRole('customer'), function ($q) {
        $q->whereHas('permohonan', function ($q) {
          $q->where('user_id', auth()->user()->id);
        });
      })->where(function ($q) {
        $q->where('status', '>=', 2)->where('status', '<=', 8);
        $q->orHas('payment');
      })->whereHas('permohonan', function ($q) {
        $q->whereHas('user', function ($q) {
          $q->where('golongan_id', 1);
        });
      })->whereYear('created_at', $request->tahun)->orderBy('kode', 'desc')->paginate($per, ['titik_permohonans.*', DB::raw('@no := @no + 1 AS no')]);

      return response()->json($data);
    } else {
      return abort(404);
    }
  }

  public function show($uuid) {
    $data = TitikPermohonan::with(['permohonan.user', 'payment'])->where('uuid', $uuid)->first();
    return response()->json([
      'data' => $data
    ]);
  }

  public function store(Request $request, $uuid) {
    $titik = TitikPermohonan::findByUuid($uuid);
    $kodeRet = KodeRetribusi::where('kode', '02')->first();

    if (isset($titik->payment)) {
      if (!$titik->payment->is_expired) {
        return response()->json([
          'message' => 'Pembayaran sudah dibuat.',
        ]);
      } else {
        $titik->payment->update([
          'status' => 'failed'
        ]);
      }
    }

    $bankJatim = new BankJatim();
    $va = $bankJatim->getVA($kodeRet);
    $nama = $titik->permohonan->user->nama;
    $jumlah = $titik->harga;
    $tanggal_exp = date('Y-m-d', strtotime('+30 day'));

    $payment = Payment::create([
      'va_number' => $va,
      'nama' => $nama,
      'jumlah' => $jumlah,
      'tanggal_exp' => $tanggal_exp,
      'berita1' => $kodeRet->kode,
      'berita2' => "Retribusi Pemakaian Lab",
      'berita3' => "Bulan " . substr(AppHelper::tanggal_indo(Carbon::parse($titik->tanggal_diterima)->format('Y-m-d')), 3),
      'berita4' => $titik->kode,
      'berita5' => "1 Sampel",
      'kode_retribusi_id' => $kodeRet->id,
      'titik_permohonan_id' => $titik->id
    ]);

    $response = '';

    $payment->genKode();
    // dd($payment);
    // dd($bankJatim->registerVA($payment));
    try {
      $response = $bankJatim->registerVA($payment);
      if (!@$response['status']) {
        Log::info([
          'va_number' => $va,
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
      Log::info([
        'va_number' => $va,
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

    $payment->titikPermohonan->update([
      'status_pembayaran' => 0
    ]);
    if (auth()->user()->id == $titik->permohonan->user_id) {
      $titik->update(['user_has_va' => 1]);
    }

    return response()->json([
      'message' => 'VA pembayaran berhasil dibuat.',
    ]);
  }

  public function cancel($uuid) {
    $titik = TitikPermohonan::findByUuid($uuid);
    $titik->payment()->update([
      'status' => 'failed'
    ]);

    return response()->json([
      'message' => 'Pembayaran berhasil dibatalkan.',
    ]);
  }

  public function check($uuid) {
    $titik = TitikPermohonan::findByUuid($uuid);
    $payment = $titik->payment;

    $bankJatim = new BankJatim();
    if ($bankJatim->checkStatus($payment)) {
      $payment->update([
        'status' => 'success',
        'is_lunas' => 1,
        'tanggal_bayar' => date('Y-m-d')
      ]);

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

      return response()->json([
        'message' => 'Pembayaran telah lunas.',
      ]);
    }

    return response()->json([
      'message' => 'Pembayaran belum lunas.',
    ], 400);
  }
}
