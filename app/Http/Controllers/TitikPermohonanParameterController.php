<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Parameter;
use App\Models\TitikPermohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TitikPermohonanParameterController extends Controller {
  public function index(Request $request, $uuid) {
    if (request()->wantsJson()) {
      $per = (($request->per) ? $request->per : 10);
      $page = (($request->page) ? $request->page - 1 : 0);

      DB::statement('set @no=0+' . $page * $per);
      $data = Parameter::with(['titikPermohonans' => function ($q) use ($uuid) {
        $q->where('titik_permohonans.uuid', $uuid);
      }])->where(function ($q) use ($request) {
        $q->where('nama', 'LIKE', '%' . $request->search . '%');
        $q->orWhere('satuan', 'LIKE', '%' . $request->search . '%');
        $q->orWhere('metode', 'LIKE', '%' . $request->search . '%');
      })->whereHas('titikPermohonans', function ($q) use ($uuid) {
        $q->where('titik_permohonans.uuid', $uuid);
      })->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

      return response()->json($data);
    } else {
      return abort(404);
    }
  }

  public function get($titik) {
    if (request()->wantsJson()) {
      $data = Parameter::whereHas('titikPermohonans', function ($q) use ($titik) {
        $q->where('titik_permohonans.uuid', $titik);
      })->pluck('uuid');

      return response()->json([
        'message' => 'Data berhasil ditemukan',
        'data' => $data
      ]);
    } else {
      return abort(404);
    }
  }

  public function store(Request $request, $titik) {
    $request->validate([
      'uuid' => 'required|exists:parameters,uuid'
    ]);

    $titik = TitikPermohonan::findByUuid($titik);
    $parameter = Parameter::findByUuid($request->uuid);

    if ($titik->parameters()->where('parameter_id', $parameter->id)->exists()) {
      return response()->json([
        'message' => 'Parameter sudah ada',
      ], 422);
    }

    $titik->parameters()->attach($parameter->id, ['harga' => $parameter->harga, 'satuan' => $parameter->satuan, 'mdl' => $parameter->mdl, 'kuantitas' => 1]);

    if ($titik->status > 1 && $titik->permohonan()->first()->user()->first()->golongan_id == 1 && $titik->status_pembayaran == 0) {
      $pembayaran = new PembayaranController();
      $pembayaran->cancel($titik->uuid);
      $pembayaran->store(request(), $titik->uuid);
    }

    return response()->json([
      'message' => 'Parameter berhasil ditambahkan',
    ]);
  }

  public function storeFromPaket(Request $request, $titik) {
    $request->validate([
      'paket_id' => 'required|numeric|exists:pakets,id'
    ]);

    $titik = TitikPermohonan::findByUuid($titik);
    $paket = Paket::find($request->paket_id);
    foreach ($paket->parameters as $parameter) {
      if ($titik->parameters()->where('parameter_id', $parameter->id)->exists()) {
        continue;
      }

      $titik->parameters()->attach($parameter->id, ['harga' => $parameter->harga, 'satuan' => $parameter->satuan, 'mdl' => $parameter->mdl, 'kuantitas' => 1]);
    }

    if ($titik->status > 1 && $titik->permohonan()->first()->user()->first()->golongan_id == 1 && $titik->status_pembayaran == 0) {
      $pembayaran = new PembayaranController();
      $pembayaran->cancel($titik->uuid);
      $pembayaran->store(request(), $titik->uuid);
    }

    return response()->json([
      'message' => 'Parameter berhasil ditambahkan',
    ]);
  }

  public function destroyFromPaket(Request $request, $titik) {
    $request->validate([
      'paket_id' => 'required|numeric|exists:pakets,id'
    ]);

    $titik = TitikPermohonan::findByUuid($titik);
    $paket = Paket::find($request->paket_id);
    foreach ($paket->parameters as $parameter) {
      $titik->parameters()->detach($parameter->id);
    }

    if ($titik->status > 1 && $titik->permohonan()->first()->user()->first()->golongan_id == 1 && $titik->status_pembayaran == 0) {
      $pembayaran = new PembayaranController();
      $pembayaran->cancel($titik->uuid);
      $pembayaran->store(request(), $titik->uuid);
    }

    return response()->json([
      'message' => 'Parameter berhasil ditambahkan',
    ]);
  }

  public function update(Request $request, $titik) {
    $request->validate([
      'uuid' => 'required|exists:parameters,uuid',
      'baku_mutu' => 'string',
      'cetak_miring' => 'boolean',
    ]);

    // Update pivot table value
    $titik = TitikPermohonan::findByUuid($titik);
    $parameter = Parameter::findByUuid($request->uuid);

    $data = $request->only(['baku_mutu', 'cetak_miring']);
    $titik->parameters()->updateExistingPivot($parameter->id, $data);

    return response()->json([
      'message' => 'Parameter berhasil diperbarui',
    ]);
  }

  public function destroy(Request $request, $titik) {
    $request->validate([
      'uuid' => 'required|exists:parameters,uuid'
    ]);

    $titik = TitikPermohonan::findByUuid($titik);
    $parameter = Parameter::findByUuid($request->uuid);

    if ($parameter->isHasPeraturan($titik->peraturan_id)) {
      $titik->update(['peraturan_id' => null]);
    }
    $titik->parameters()->detach($parameter->id);

    if ($titik->status > 1 && $titik->permohonan()->first()->user()->first()->golongan_id == 1 && $titik->status_pembayaran == 0) {
      $pembayaran = new PembayaranController();
      $pembayaran->cancel($titik->uuid);
      $pembayaran->store(request(), $titik->uuid);
    }

    return response()->json([
      'message' => 'Parameter berhasil dihapus',
    ]);
  }
}
