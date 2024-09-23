<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\KodeRetribusi;
use App\Models\MultiPayment;
use App\Models\Payment;
use App\Models\TitikPermohonan;
use App\Services\BankJatim;
use App\Services\BankJatimQris;
use App\Services\WhatsApp;
use Carbon\Carbon;
use chillerlan\QRCode\QRCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MultiPaymentController extends Controller {
  private function checkExpired() {
    $payments = Payment::where('status', 'pending')->get();
    foreach ($payments as $payment) {
      if ($payment->is_expired) {
        // $payment->update([
        //     'status' => 'failed'
        // ]);

        foreach ($payment->multiPayments as $multi) {
          $multi->titikPermohonan->update([
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
      $data = Payment::with(['multiPayments.titikPermohonan.permohonan.user'])->where(function ($q) use ($request) {
        $q->whereHas('multiPayments.titikPermohonan', function ($q) use ($request) {
          $q->where('kode', 'LIKE', '%' . $request->search . '%');
          $q->orWhere('lokasi', 'LIKE', '%' . $request->search . '%');
        });
      })->when(auth()->user()->hasRole('customer'), function ($q) {
        $q->whereHas('multiPayments.titikPermohonan', function ($q) {
          $q->whereHas('permohonan', function ($q) {
            $q->where('user_id', auth()->user()->id);
          });
        });
      })->where('type', $request->type)->whereYear('created_at', $request->tahun)->whereMonth('created_at', $request->bulan)->orderBy('kode', 'desc')->paginate($per, ['payments.*', DB::raw('@no := @no + 1 AS no')]);

      $data->map(function ($a) {
        $a->tanggal_bayar = $a->tanggal_bayar ? AppHelper::tanggal_indo(Carbon::parse($a->tanggal_bayar)->format('Y-m-d')) : '-';
      });
      return response()->json($data);
    } else {
      return abort(404);
    }
  }

  public function titiks(Request $request) {
    if (request()->wantsJson()) {
      $per = (($request->per) ? $request->per : 10);
      $page = (($request->page) ? $request->page - 1 : 0);

      $multiPayments = MultiPayment::get()->pluck('titik_permohonan_id');

      DB::statement('set @no=0+' . $page * $per);
      $data = TitikPermohonan::with(['permohonan.user'])->where(function ($q) use ($request) {
        $q->where('kode', 'LIKE', '%' . $request->search . '%');
        $q->orWhere('lokasi', 'LIKE', '%' . $request->search . '%');
        $q->orWhereHas('permohonan', function ($q) use ($request) {
          $q->whereHas('user', function ($q) use ($request) {
            $q->where('nama', 'LIKE', '%' . $request->search . '%');
          });
        });
      })->whereNotIn('titik_permohonans.id', $multiPayments)->where('status_pembayaran', '!=', 1)->where('payment_type', $request->type)->orderBy('kode', 'desc')->paginate($per, ['titik_permohonans.*', DB::raw('@no := @no + 1 AS no')]);

      return response()->json($data);
    } else {
      return abort(404);
    }
  }

  public function store(Request $request) {
    $body = $request->validate([
      'type' => 'required|string|in:va,qris',
      'multiPayments' => 'required|array|min:1',
    ]);

    $kodeRet = KodeRetribusi::where('kode', '02')->first();

    $nama = '';
    $jumlah = 0;
    foreach ($body['multiPayments'] as $item) {
      $titik = TitikPermohonan::find($item['titik_permohonan_id']);
      $jumlah += $titik->harga;
      $nama = $titik->permohonan->user->nama;

      $titik->payment()->update([
        'status' => 'failed'
      ]);
    }

    $payment = Payment::create([
      'type' => $body['type'],
      'jumlah' => $jumlah,
      'nama' => $nama,
      'kode_retribusi_id' => $kodeRet->id,
      'multi_payment' => 1
    ]);

    foreach ($body['multiPayments'] as $item) {
      $payment->multiPayments()->create([
        'titik_permohonan_id' => $item['titik_permohonan_id']
      ]);
    }

    $payment->genKode();

    return response()->json([
      'message' => 'Multi Payment berhasil dibuat.',
    ]);
  }

  public function show($uuid) {
    $data = Payment::with(['multiPayments.titikPermohonan.permohonan.user'])->where('uuid', $uuid)->first();

    return response()->json([
      'data' => $data
    ]);
  }

  public function storeVa(Request $request, $uuid) {
    $payment = Payment::findByUuid($uuid);
    $kodeRet = KodeRetribusi::where('kode', '02')->first();

    $bankJatim = new BankJatim();
    $va = $bankJatim->getVA($kodeRet);
    $tanggal_exp = date('Y-m-d', strtotime('+30 day'));

    $payment->update([
      'va_number' => $va,
      'tanggal_exp' => $tanggal_exp,
      'berita1' => $kodeRet->kode,
      'berita2' => "Retribusi Pemakaian Lab",
      'berita3' => "Bulan " . substr(AppHelper::tanggal_indo(Carbon::parse($payment->created_at)->format('Y-m-d')), 3),
      'berita4' => $payment->multiPayments->map(function ($a) {
        return explode("-", $a->titikPermohonan->kode)[2];
      })->join(''),
      // 'berita4' => $payment->multiPayments[0]->titikPermohonan->kode,
      'berita5' => $payment->multiPayments->count() . " Sampel",
    ]);

    $response = '';

    // $payment->genKode();
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

        $payment->update([
          'status' => 'pending',
          'va_number' => null
        ]);
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

      $payment->update([
        'status' => 'pending',
        'va_number' => null
      ]);
      return response()->json([
        'message' => 'VA pembayaran gagal dibuat. Silahkan coba lagi.',
      ], 500);
    }

    foreach ($payment->multiPayments as $item) {
      $item->titikPermohonan->update([
        'status_pembayaran' => 0
      ]);
      if (auth()->user()->id == $item->titikPermohonan->permohonan->user_id) {
        $item->titikPermohonan->update(['user_has_va' => 1]);
      }
    }

    return response()->json([
      'message' => 'VA pembayaran berhasil dibuat.',
    ]);
  }

  public function storeQris(Request $request, $uuid) {
    $payment = Payment::findByUuid($uuid);

    $bankJatim = new BankJatimQris();
    $qris_expired = date('Y-m-d H:i:s', strtotime('+30 day'));
    $qris_number = time() . $payment->multiPayments->map(function ($a) {
      return $a->titikPermohonan->id;
    })->join('');

    $payment->update([
      'qris_expired' => $qris_expired,
      'qris_number' => $qris_number,
    ]);

    $response = '';

    // $payment->genKode();
    // dd($payment);
    // dd($bankJatim->registerVA($payment));
    try {
      $response = $bankJatim->createQR($payment);
      if (!@$response['status']) {
        Log::info([
          'qris_number' => $qris_number,
          'status' => 'error',
          // 'status' => 'success',
          'message' => json_encode($response),
          'ip_address' => $request->ip(),
          'user_agent' => $request->userAgent(),
          'created_at' => date('Y-m-d H:i:s')
        ]);

        $payment->update([
          'status' => 'pending',
          'qris_number' => null,
          'qris_expired' => null,
        ]);
        return response()->json([
          'message' => 'QRIS gagal dibuat. Silahkan coba lagi.',
        ], 500);
      }
    } catch (\Throwable $th) {
      Log::info([
        'qris_number' => $qris_number,
        'status' => 'error',
        // 'status' => 'success',
        'message' => json_encode($th->getMessage()),
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'created_at' => date('Y-m-d H:i:s')
      ]);

      $payment->update([
        'status' => 'pending',
        'qris_number' => null,
        'qris_expired' => null,
      ]);
      return response()->json([
        'message' => 'QRIS gagal dibuat. Silahkan coba lagi.',
      ], 500);
    }

    $payment->update([
      'qris_value' => $response['qrValue']
    ]);
    foreach ($payment->multiPayments as $item) {
      $item->titikPermohonan->update([
        'status_pembayaran' => 0
      ]);
      if (auth()->user()->id == $item->titikPermohonan->permohonan->user_id) {
        $item->titikPermohonan->update(['user_has_va' => 1]);
      }
    }

    return response()->json([
      'message' => 'QRIS berhasil dibuat.',
    ]);
  }

  public function whatsapp(Request $request) {
    $uuid = $request->query('uuid');

    $payment = Payment::findByUuid($uuid);
    $formattedDate = AppHelper::tanggal_indo(Carbon::parse($payment['tanggal_exp'])->format('Y-m-d'));
    $formattedPrice = AppHelper::rupiah($payment['jumlah']);

    $phone = $payment->multiPayments->first()->titikPermohonan->permohonan->user->phone;
    $wa = new WhatsApp($phone);
    $wa->send('Kepada pelanggan ' . $payment['nama'] . ' yang terhormat. ' . "\n\n" . 'Silahkan melakukan pembayaran sebesar ' . '*' . $formattedPrice . '*' . ', sebelum tanggal ' . '*' . $formattedDate . '*' . ' melalui Scan QRIS berikut ');

    $qrFile = (new QRCode)->render($payment['qris_value'], storage_path('app/public/qris/' . $payment['qris_number'] . '.png'));
    $wa->sendFile(url("/storage/qris/" . $payment['qris_number'] . '.png'));

    return response()->json([
      'data' => $payment
    ]);
  }
}
