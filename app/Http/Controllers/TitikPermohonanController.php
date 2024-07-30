<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\JenisSampel;
use App\Models\Permohonan;
use App\Models\TitikPermohonan;
use App\Models\TrackingPengujian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TitikPermohonanController extends Controller {
  public function index(Request $request) {
    if (request()->wantsJson()) {
      $per = (($request->per) ? $request->per : 10);
      $page = (($request->page) ? $request->page - 1 : 0);

      DB::statement('set @no=0+' . $page * $per);
      $data = TitikPermohonan::with(['payment', 'permohonan'])->where(function ($q) use ($request) {
        $q->where('kode', 'LIKE', '%' . $request->search . '%');
        $q->orWhere('lokasi', 'LIKE', '%' . $request->search . '%');
      })->orderBy('created_at', 'DESC')->whereHas('permohonan', function ($q) use ($request) {
        $q->where('uuid', $request->permohonan_uuid);
      })->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

      $data->map(function ($a) {
        $a->tgl_diterima = $a->tgl_diterima ? AppHelper::tanggal_indo($a->tgl_diterima) : '-';
      });

      return response()->json($data);
    } else {
      return abort(404);
    }
  }

  public function store(Request $request) {
    if (auth()->user()->has_tagihan) {
      return response()->json([
        'message' => 'Anda masih memiliki tagihan yang belum dibayar. Silahkan selesaikan pembayaran terlebih dahulu.',
      ], 422);
    }

    $rules = [
      'lokasi' => 'required',
      'jenis_sampel_id' => 'required',
      'jenis_wadahs_id' => 'required|array|min:1',
      'permohonan_uuid' => 'required',
    ];

    $permohonan = Permohonan::findByUuid($request->permohonan_uuid);
    if ($permohonan->is_mandiri) {
      $rules['tanggal_pengambilan'] = 'required';
      $rules['nama_pengambil'] = 'required';
      $rules['acuan_metode_id'] = 'required';
      $rules['south'] = 'required';
      $rules['east'] = 'required';
    }

    $this->validate($request, $rules);

    $data = $request->all();
    $data['kode'] = '(Belum Ditetapkan)';
    $data['no_lhu'] = '(Belum Ditetapkan)';
    $data['no_formulir'] = '(Belum Ditetapkan)';
    $data['permohonan_id'] = $permohonan->id;
    if ($permohonan->is_mandiri) {
      $data['status'] = 1;
    } else {
      $data['status'] = 0;
    }

    if ($titik = TitikPermohonan::create($data)) {
      TrackingPengujian::create(['titik_permohonan_id' => $titik->id, 'status' => $titik->status]);
      $titik->jenisWadahs()->sync($request->jenis_wadahs_id);

      return response()->json([
        'status' => 'success',
        'message' => 'Data berhasil disimpan',
        'data' => $titik
      ]);
    }
  }

  public function edit($uuid) {
    $permohonan = TitikPermohonan::findByUuid($uuid);
    return response()->json([
      'data' => $permohonan
    ]);
  }

  public function show($uuid) {
    $permohonan = TitikPermohonan::findByUuid($uuid);
    return response()->json([
      'data' => $permohonan
    ]);
  }

  public function update(Request $request, $uuid) {
    $rules = [
      'lokasi' => 'required',
      'jenis_sampel_id' => 'required',
      'jenis_wadahs_id' => 'required|array|min:1',
      'permohonan_uuid' => 'required',
    ];

    $permohonan = Permohonan::findByUuid($request->permohonan_uuid);
    if ($permohonan->is_mandiri) {
      $rules['tanggal_pengambilan'] = 'required';
      $rules['nama_pengambil'] = 'required';
      $rules['acuan_metode_id'] = 'required';
      $rules['south'] = 'required';
      $rules['east'] = 'required';
    }

    $this->validate($request, $rules);

    $data = $request->only([
      'lokasi',
      'jenis_sampel_id',
      'jenis_wadah_id',
      'permohonan_uuid',
      'tanggal_pengambilan',
      'nama_pengambil',
      'acuan_metode_id',
      'south',
      'east',
      'lapangan'
    ]);

    $titik = TitikPermohonan::findByUuid($uuid);
    $is_from_revisi = $titik->status == -1;
    if ($is_from_revisi) {
      if ($permohonan->is_mandiri) {
        $data['status'] = 1;
      } else {
        $data['status'] = 0;
      }
    }

    if ($request->ajukan_ulang) {
      if ($request->kesimpulan_permohonan == 2) {
        $data['kesimpulan_permohonan'] = 0;
      }
      if ($request->kesimpulan_sampel == 2) {
        $data['kesimpulan_sampel'] = 0;
      }
    }

    if ($titik->update($data)) {
      $titik->jenisWadahs()->sync($request->jenis_wadahs_id);

      if ($is_from_revisi) {
        TrackingPengujian::create(['titik_permohonan_id' => $titik->id, 'status' => $titik->status]);
      }

      unset($data['lapangan']['id']);
      unset($data['lapangan']['titik_permohonan_id']);
      unset($data['lapangan']['created_at']);
      unset($data['lapangan']['updated_at']);

      if (isset($titik->lapangan)) {
        $titik->lapangan()->update($data['lapangan']);
      } else {
        $titik->lapangan()->create($data['lapangan']);
      }

      return response()->json([
        'status' => 'success',
        'message' => 'Data berhasil disimpan',
        'data' => $titik
      ]);
    }
  }

  public function saveParameter(Request $request, $uuid) {
    $data = TitikPermohonan::findByUuid($uuid);
    $data->update(['save_parameter' => 1]);

    return response()->json([
      'message' => 'Data berhasil disimpan.',
    ]);
  }

  public function destroy($uuid) {
    $titik = TitikPermohonan::findByUuid($uuid);
    if ($titik->delete()) {
      return response()->json([
        'message' => 'Data berhasil dihapus.',
      ]);
    }
  }

  public function statusTte(Request $request, $uuid) {
    $titik = TitikPermohonan::findByUuid($uuid);
    return response()->json(['status_tte' => $titik[$request->column]]);
  }
}
