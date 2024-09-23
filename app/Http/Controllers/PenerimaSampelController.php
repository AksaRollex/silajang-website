<?php

namespace App\Http\Controllers;

use App\Models\LiburCuti;
use App\Models\TitikPermohonan;
use App\Models\TrackingPengujian;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PenerimaSampelController extends Controller {
  public function index(Request $request) {
    if (request()->wantsJson()) {
      $per = (($request->per) ? $request->per : 10);
      $page = (($request->page) ? $request->page - 1 : 0);

      DB::statement('set @no=0+' . $page * $per);
      $data = TitikPermohonan::with(['permohonan.user'])->without(['parameters', 'jenisWadahs'])->has('parameters')->where(function ($q) use ($request) {
        $q->where('kode', 'LIKE', '%' . $request->search . '%');
        $q->orWhere('lokasi', 'LIKE', '%' . $request->search . '%');
      })->where(function ($q) use ($request) {
        if ($request->status == 1) {
          $q->where('status', 1);
        } else {
          $q->where('status', '>', 1);
        }
      })->whereYear('created_at', $request->tahun)->orderBy('kode', 'desc')->paginate($per, ['titik_permohonans.*', DB::raw('@no := @no + 1 AS no')]);

      return response()->json($data);
    } else {
      return abort(404);
    }
  }

  public function show($uuid) {
    $titik = TitikPermohonan::with(['permohonan' => function ($q) {
      $q->with(['jasaPengambilan', 'user.detail']);
    }, 'peraturan', 'parameters', 'acuanMetode'])->where('uuid', $uuid)->first();

    if (!$titik) {
      return abort(404);
    }

    $data = collect($titik)->forget('parameters');
    $data['parameters'] = $titik->getParamsByUser();

    return response()->json([
      'data' => $data,
      'status' => 'success',
    ]);
  }

  public function update(Request $request, $uuid) {
    $request->validate([
      'lab_subkontrak' => 'nullable',
      'kesimpulan_sampel' => 'nullable',
      'kondisi_sampel' => 'nullable',
      'keterangan_kondisi_sampel' => 'nullable',
      'parameters' => 'array',
      'tanggal_diterima' => 'string'
    ]);

    $data = $request->only([
      'lab_subkontrak',
      'kesimpulan_sampel',
      'kondisi_sampel',
      'keterangan_kondisi_sampel',
      'pengawetan_oleh',
      'baku_mutu',
      'hasil_pengujian',
      'memenuhi_hasil_pengujian',
      'tanggal_diterima'
    ]);

    $data['tanggal_diterima'] = Carbon::parse($data['tanggal_diterima'])->format('Y-m-d H:i:s');

    $titik = TitikPermohonan::where('uuid', $uuid)->first();
    if (!$titik) {
      return abort(404);
    }

    if ($titik->update($data)) {
      foreach ($request->parameters as $param) {
        unset($param['pivot']['created_at']);
        unset($param['pivot']['updated_at']);
        $titik->parameters()->updateExistingPivot($param['id'], $param['pivot']);
      }

      return response()->json([
        'status' => 'success',
      ]);
    }
  }

  public function updateStatus(Request $request, $uuid) {
    $request->validate([
      'status' => 'required|in:-1,0,1,2',
    ]);

    $titik = TitikPermohonan::where('uuid', $uuid)->first();
    if (!$titik) {
      return abort(404);
    }

    if ($titik->kesimpulan_sampel != 1) {
      return response()->json([
        'message' => 'Kesimpulan Sampel harus diterima'
      ], 400);
    }

    $data = $request->only(['status']);
    if ($data['status'] == 2) {
      $data['status'] = 3; // Skip status 2 (Koor. Administrasi ke Koor. Teknis) langsung ke status 3 (Koor. Teknis ke Koor. Analis)

      // $data['tanggal_diterima'] = date('Y-m-d H:i:s');

      $date = date('Y-m-d H:i:s');
      $MyDateCarbon = Carbon::parse($date);
      $addDays = 10;

      $MyDateCarbon->addWeekdays($addDays);

      $holidays = LiburCuti::whereBetween('tanggal', [date('Y-m-d'), $MyDateCarbon])->pluck('tanggal');
      $holidays = $holidays->map(function ($item) {
        return Carbon::parse($item)->toDateString();
      })->toArray();

      for ($i = 0; $i <= $addDays; $i++) {
        if (in_array(Carbon::parse($date)->addWeekdays($i)->toDateString(), $holidays)) {
          $MyDateCarbon->addWeekday();
        }
      }

      $data['tanggal_selesai'] = date_create($MyDateCarbon)->format('Y-m-d H:i:s');

      if ($titik->no_formulir === '(Belum Ditetapkan)') $titik->genNoFormulir();
      if ($titik->kode === '(Belum Ditetapkan)') $titik->genKode();
    } else if ($data['status'] < 2) {
      // $data['tanggal_diterima'] = null;
      $data['tanggal_selesai'] = null;

      if ($titik->permohonan->is_mandiri) $data['no_formulir'] = '(Belum Ditetapkan)';
      if ($titik->permohonan->is_mandiri) $data['kode'] = '(Belum Ditetapkan)';
    }

    if ($titik->update($data)) {
      if ($titik->status == 3) {
        TrackingPengujian::create(['titik_permohonan_id' => $titik->id, 'status' => 2]);
        TrackingPengujian::create(['titik_permohonan_id' => $titik->id, 'status' => 3]);
      } else {
        TrackingPengujian::create(['titik_permohonan_id' => $titik->id, 'status' => $titik->status]);
      }

      return response()->json([
        'status' => 'success',
      ]);
    }
  }

  public function revisi(Request $request, $uuid) {
    $request->validate([
      'keterangan_revisi' => 'required',
    ]);

    $titik = TitikPermohonan::where('uuid', $uuid)->first();
    if (!$titik) {
      return abort(404);
    }

    $data = $request->only(['keterangan_revisi']);
    $data['status'] = -1;

    if ($titik->update($data)) {
      TrackingPengujian::create(['titik_permohonan_id' => $titik->id, 'status' => $titik->status, 'keterangan' => $data['keterangan_revisi']]);

      return response()->json([
        'status' => 'success',
      ]);
    }
  }
}
