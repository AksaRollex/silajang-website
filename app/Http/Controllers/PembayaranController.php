<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\KodeRetribusi;
use App\Models\MultiPayment;
use App\Models\Payment;
use App\Models\TitikPermohonan;
use App\Models\TrackingPengujian;
use App\Services\BankJatim;
use App\Services\BankJatimQris;
use App\Services\WhatsApp;
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

      $multiPayments = MultiPayment::get()->pluck('titik_permohonan_id');
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
      })->when(isset($request->type), function ($q) use ($request) {
        $q->where('payment_type', $request->type);
      })->whereNotIn('titik_permohonans.id', $multiPayments)->whereYear('created_at', $request->tahun)->whereMonth('created_at', $request->bulan)->orderBy('kode', 'desc')->paginate($per, ['titik_permohonans.*', DB::raw('@no := @no + 1 AS no')]);

      $data->map(function ($a) {
        if (isset($a->payment)) {
          $a->payment->tanggal_bayar = $a->payment->tanggal_bayar ? AppHelper::tanggal_indo(Carbon::parse($a->payment->tanggal_bayar)->format('Y-m-d')) : '-';
        }
      });
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

  public function store(Request $request, $uuid, $update = false) {
    $titik = TitikPermohonan::findByUuid($uuid);
    $kodeRet = KodeRetribusi::where('kode', '02')->first();

    if (isset($titik->payment)) {
      if ($update) {
        if ($titik->payment->is_expired) {
          $titik->payment->update([
            'status' => 'failed'
          ]);
        }
      } else {
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
    }

    $bankJatim = new BankJatim();
    $va = $bankJatim->getVA($kodeRet);
    $nama = $titik->permohonan->user->nama;
    $jumlah = $titik->harga;
    $tanggal_exp = date('Y-m-d', strtotime('+30 day'));

    if (!isset($titik->payment)) {
      $payment = Payment::create([
        'type' => 'va',
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
    } else {
      $payment = $titik->payment;
      $payment->update([
        'type' => 'va',
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
    }

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

  public function storeQris(Request $request, $uuid, $update = false) {
    $titik = TitikPermohonan::findByUuid($uuid);
    $kodeRet = KodeRetribusi::where('kode', '02')->first();

    if (isset($titik->payment)) {
      if ($update) {
        if ($titik->payment->is_expired) {
          $titik->payment->update([
            'status' => 'failed'
          ]);
        }
      } else {
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
    }


    $bankJatim = new BankJatimQris();
    $jumlah = $titik->harga;
    $qris_expired = date('Y-m-d H:i:s', strtotime('+30 day'));
    $qris_number = time() . $titik->id;

    if (!isset($titik->payment)) {
      $payment = Payment::create([
        'type' => 'qris',
        'jumlah' => $jumlah,
        'kode_retribusi_id' => $kodeRet->id,
        'titik_permohonan_id' => $titik->id,
        'qris_expired' => $qris_expired,
        'qris_number' => $qris_number,
      ]);
    } else {
      $payment = $titik->payment;
      $payment->update([
        'type' => 'qris',
        'jumlah' => $jumlah,
        'kode_retribusi_id' => $kodeRet->id,
        'titik_permohonan_id' => $titik->id,
        'qris_expired' => $qris_expired,
        'qris_number' => $qris_number,
      ]);
    }

    $response = '';

    $payment->genKode();
    // dd($payment);
    // dd($bankJatim->registerVA($payment));
    try {
      $response = $bankJatim->createQR($payment);
      if ($response->failed()) {
        Log::info([
          'qris_number' => $qris_number,
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
        'qris_number' => $qris_number,
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
    $payment->titikPermohonan->update([
      'status_pembayaran' => 0
    ]);
    if (auth()->user()->id == $titik->permohonan->user_id) {
      $titik->update(['user_has_va' => 1]);
    }

    return response()->json([
      'message' => 'QRIS berhasil dibuat.',
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

  public function whatsapp(Request $request) {
    $uuid = $request->query('uuid');
    $data = TitikPermohonan::with('permohonan.user', 'payment')->where('uuid', $uuid)->first();

    $payment = $data->payment;
    $formattedDate = AppHelper::tanggal_indo(Carbon::parse($payment['tanggal_exp'])->format('Y-m-d'));
    $formattedPrice = AppHelper::rupiah($payment['jumlah']);

    $phone = $data->permohonan->user->phone;
    $wa = new WhatsApp($phone);
    $wa->send('Kepada pelanggan ' . $payment['nama'] . ' yang terhormat. ' . "\n\n" . 'Silahkan melakukan pembayaran sebesar ' . '*' . $formattedPrice . '*' . ', sebelum tanggal ' . '*' . $formattedDate . '*' . ' ke nomor Virtual Account berikut ' . '*' . $payment['va_number'] . '*' . '.');

    return response()->json([
      'data' => $data
    ]);
  }

  public function postPaymentQr(Request $request) {
    Log::info("=== POST PAYMENT QR ===");
    Log::info($request->all());

    $request->validate([
      'billNumber' => 'required',
      'merchantPan' => 'required',
    ]);

    if ($request->merchantPan != env('QRIS_MERCHANT_PAN')) {
      return response()->json([
        'message' => false,
      ], 500);
    }

    $payment = Payment::where('qris_number', $request->billNumber)->first();
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

    $body = $request->all();
    $body['responsCode'] = "00";
    $body['responsDesc'] = "Success";

    return response()->json($body);
  }
}
