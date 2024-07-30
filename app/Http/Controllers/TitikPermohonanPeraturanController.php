<?php

namespace App\Http\Controllers;

use App\Models\Peraturan;
use App\Models\TitikPermohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TitikPermohonanPeraturanController extends Controller {
  public function index(Request $request, $titik) {
    if (request()->wantsJson()) {
      $per = (($request->per) ? $request->per : 10);
      $page = (($request->page) ? $request->page - 1 : 0);

      DB::statement('set @no=0+' . $page * $per);
      $data = Peraturan::where(function ($q) use ($request) {
        $q->where('nama', 'LIKE', '%' . $request->search . '%');
        $q->orWhere('nomor', 'LIKE', '%' . $request->search . '%');
        $q->orWhere('tentang', 'LIKE', '%' . $request->search . '%');
      })->orderBy('created_at', 'DESC')->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

      $titik = TitikPermohonan::findByUuid($titik);
      $data->map(function ($a) use ($titik) {
        if ($titik->peraturan_id == $a->id) {
          $a->selected = true;
        }
      });

      return response()->json($data);
    } else {
      return abort(404);
    }
  }

  public function store(Request $request, $titik) {
    $request->validate([
      'uuid' => 'required|exists:peraturans,uuid',
    ]);

    $peraturan = Peraturan::where('uuid', $request->uuid)->first();
    $titik = TitikPermohonan::findByUuid($titik);

    $titik->update([
      'peraturan_id' => $peraturan->id,
    ]);

    $parameters = [];
    foreach ($peraturan->parameters as $param) {
      $parameters[$param->id] = ['harga' => $param->harga, 'satuan' => $param->satuan, 'mdl' => $param->mdl, 'kuantitas' => 1, 'baku_mutu' => $param->pivot->baku_mutu];
    }
    // dd($parameters);

    $titik->parameters()->sync($parameters);

    if ($titik->status > 1 && $titik->permohonan()->first()->user()->first()->golongan_id == 1 && $titik->status_pembayaran == 0) {
      $pembayaran = new PembayaranController();
      $pembayaran->cancel($titik->uuid);
      $pembayaran->store(request(), $titik->uuid);
    }

    return response()->json([
      'message' => 'Peraturan berhasil ditambahkan',
    ]);
  }

  public function destroy(Request $request, $titik) {
    $request->validate([
      'uuid' => 'required|exists:peraturans,uuid',
    ]);

    $peraturan = Peraturan::where('uuid', $request->uuid)->first();
    $titik = TitikPermohonan::findByUuid($titik);

    $titik->update([
      'peraturan_id' => null,
    ]);
    $titik->parameters()->detach();

    if ($titik->status > 1 && $titik->permohonan()->first()->user()->first()->golongan_id == 1 && $titik->status_pembayaran == 0) {
      $pembayaran = new PembayaranController();
      $pembayaran->cancel($titik->uuid);
      $pembayaran->store(request(), $titik->uuid);
    }

    return response()->json([
      'message' => 'Peraturan berhasil dihapus',
    ]);
  }
}
