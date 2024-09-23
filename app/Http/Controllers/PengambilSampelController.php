<?php

namespace App\Http\Controllers;

use App\Models\TitikPermohonan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\AppHelper;
use App\Models\TitikPermohonanLapangan;
use App\Models\TrackingPengujian;
use Illuminate\Support\Carbon;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class PengambilSampelController extends Controller {
  public function index(Request $request) {
    if (request()->wantsJson()) {
      $per = (($request->per) ? $request->per : 10);
      $page = (($request->page) ? $request->page - 1 : 0);

      DB::statement('set @no=0+' . $page * $per);
      $data = TitikPermohonan::with(['permohonan.user'])->without(['parameters', 'jenisWadahs'])->has('parameters')->where(function ($q) use ($request) {
        $q->where('kode', 'LIKE', '%' . $request->search . '%');
        $q->orWhere('lokasi', 'LIKE', '%' . $request->search . '%');
      })->where(function ($q) use ($request) {
        if ($request->status == 0) {
          $q->where('status', 0);
        } else {
          $q->where('status', '>', 0);
        }
      })->whereHas('permohonan', function ($q) {
        $q->where('is_mandiri', 0);
      })->whereYear('created_at', $request->tahun)->orderBy('created_at', 'desc')->paginate($per, ['titik_permohonans.*', DB::raw('@no := @no + 1 AS no')]);

      return response()->json($data);
    } else {
      return abort(404);
    }
  }

  public function show($uuid) {
    $titik = TitikPermohonan::with(['permohonan' => function ($q) {
      $q->with(['jasaPengambilan', 'user.detail', 'radiusPengambilan']);
    }, 'petugasPengambils', 'peraturan', 'parameters', 'acuanMetode', 'photos'])->where('uuid', $uuid)->first();

    if (!$titik) {
      return abort(404);
    }

    $data = collect($titik)->forget('parameters');
    $data['parameters'] = $titik->getParamsByUser();
    $data['petugas_pengambil_ids'] = $titik->petugasPengambils->pluck('id')->toArray();
    $data['tanggal_pengambilan_indo'] = AppHelper::tanggal_indo(Carbon::parse($titik->tanggal_pengambilan)->format('Y-m-d')) . ' ' . Carbon::parse($titik->tanggal_pengambilan)->format('H:i');

    return response()->json([
      'data' => $data,
      'status' => 'success',
    ]);
  }

  public function petugas() {
    $data = User::whereHas('roles', function ($q) {
      $q->where('name', 'pengambil-sample');
    })->get();

    return response()->json([
      'data' => $data,
      'status' => 'success',
    ]);
  }

  public function update(Request $request, $uuid) {
    $request->validate([
      'tanggal_pengambilan' => 'nullable',
      'petugas_pengambil_ids' => 'nullable',
      'acuan_metode_id' => 'nullable',
      'south' => 'nullable',
      'east' => 'nullable',
      'lab_subkontrak' => 'nullable',
      'hasil_pengujian' => 'nullable',
      'kesimpulan_permohonan' => 'nullable',
      'parameters' => 'array',
    ]);

    $data = $request->only([
      'tanggal_pengambilan',
      'petugas_pengambil_ids',
      'acuan_metode_id',
      'south',
      'east',
      'lab_subkontrak',
      'hasil_pengujian',
      'kesimpulan_permohonan',
      'lapangan',
      'obyek_pelayanan'
    ]);
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

      unset($data['lapangan']['id']);
      unset($data['lapangan']['titik_permohonan_id']);
      unset($data['lapangan']['created_at']);
      unset($data['lapangan']['updated_at']);

      if (isset($titik->lapangan)) {
        $titik->lapangan->update($data['lapangan']);
      } else {
        $data['lapangan']['titik_permohonan_id'] = $titik->id;
        TitikPermohonanLapangan::create($data['lapangan']);
      }

      if (isset($request->permohonan['radius_pengambilan_id'])) {
        $titik->permohonan()->update(['radius_pengambilan_id' => $request->permohonan['radius_pengambilan_id']]);
      }

      if (isset($request->petugas_pengambil_ids)) {
        $titik->petugasPengambils()->sync($request->petugas_pengambil_ids);
      }

      return response()->json([
        'status' => 'success',
      ]);
    }
  }

  public function updateStatus(Request $request, $uuid) {
    $request->validate([
      'status' => 'required|in:0,1',
    ]);

    $titik = TitikPermohonan::where('uuid', $uuid)->first();

    if (!$titik) {
      return abort(404);
    }

    if ($titik->kesimpulan_permohonan != 1) {
      return response()->json([
        'message' => 'Kesimpulan Permohonan harus diterima'
      ], 400);
    }

    if ($titik->update($request->only('status'))) {
      // if ($request->status == 1) {
      //     if ($titik->no_formulir === '(Belum Ditetapkan)') $titik->genNoFormulir();
      //     if ($titik->kode === '(Belum Ditetapkan)') $titik->genKode();
      // }

      TrackingPengujian::create(['titik_permohonan_id' => $titik->id, 'status' => $titik->status]);

      return response()->json([
        'status' => 'success',
      ]);
    }
  }

  public function uploadPhoto(Request $request, $uuid) {
    $request->validate([
      'photos' => 'required|array|min:1',
      'photos.*' => 'required|image|mimes:jpeg,png,jpg',
    ]);

    $titik = TitikPermohonan::where('uuid', $uuid)->first();

    if (!$titik) {
      return abort(404);
    }

    // Delete old photos
    foreach ($titik->photos as $photo) {
      $photo->delete();
    }

    $manager = new ImageManager(Driver::class);
    foreach ($request->photos as $photo) {

      $image = $manager->read($photo);
      $image->scaleDown(1000);

      $file = 'foto_lapangan/' . \Ramsey\Uuid\Uuid::uuid4()->toString() . '.' . $photo->extension();
      $path = storage_path('app/public/' . $file);
      $image->save($path);

      $titik->photos()->create(['foto' => '/storage/' . $file]);
    }

    return response()->json([
      'status' => 'success',
    ]);
  }
}
