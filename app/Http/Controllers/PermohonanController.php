<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kontrak;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Storage;

class PermohonanController extends Controller {
  public function get() {
    return response()->json([
      'message' => 'Data berhasil ditemukan',
      'data' => Permohonan::get()
    ]);
  }

  public function index(Request $request) {
    if (request()->wantsJson()) {
      $per = (($request->per) ? $request->per : 10);
      $page = (($request->page) ? $request->page - 1 : 0);

      DB::statement('set @no=0+' . $page * $per);
      $data = Permohonan::with(['jasaPengambilan', 'kontrak', 'titikPermohonans.parameters', 'titikPermohonans.jenisWadahs'])->where(function ($q) use ($request) {
        $q->where('keterangan', 'LIKE', '%' . $request->search . '%');
        $q->orWhere('industri', 'LIKE', '%' . $request->search . '%');
        $q->orWhere('kegiatan', 'LIKE', '%' . $request->search . '%');
        $q->orWhere('alamat', 'LIKE', '%' . $request->search . '%');
        $q->orWhere('pembayaran', 'LIKE', '%' . $request->search . '%');
      })->whereYear('created_at', $request->tahun)->where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

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

    $data = $request->validate([
      'industri' => 'required',
      'alamat' => 'required',
      'kegiatan' => 'required',
      'keterangan' => 'nullable',
      'pembayaran' => 'required|in:tunai,transfer',
      'is_mandiri' => 'required|in:0,1',
      'jasa_pengambilan_id' => 'required_if:is_mandiri,0',
      'jenis_contoh_id' => 'nullable',
    ]);
    $data['user_id'] = auth()->user()->id;

    // if ($request->is_mandiri == 1) {
    // $data['jasa_pengambilan_id'] = null;

    $permohonan = Permohonan::create($data);
    return response()->json([
      'permohonan' => $permohonan,
      'message' => 'Data berhasil disimpan.'
    ]);
    // }

    // $dataKontrak = $request->validate([
    //   'nomor_surat' => 'required_if:is_mandiri,0',
    //   'dokumen_permohonan' => 'required_if:is_mandiri,0|mimes:pdf|max:2000',
    //   'perihal' => 'required_if:is_mandiri,0',
    //   'tanggal_surat' => 'required_if:is_mandiri,0',
    //   'bulan' => 'required_if:is_mandiri,0|array',
    // ]);

    // if ($request->is_mandiri == 0) {
    //   if ($request->hasFile('dokumen_permohonan')) {
    //     $dataKontrak['dokumen_permohonan'] = $request->file('dokumen_permohonan')->store('dokumen-permohonan', 'public');
    //   }

    //   $kontrak = Kontrak::create($dataKontrak);
    //   $data['kontrak_id'] = $kontrak->id;
    //   $data['kesimpulan_kontrak'] = 0;
    //   $permohonan = Permohonan::create($data);
    //   return response()->json([
    //     'permohonan' => $permohonan,
    //     'kontrak' => $kontrak,
    //     'message' => 'Data berhasil disimpan.',
    //   ]);
    // }

    // return response()->json(['message' => 'Error'], 422);
  }

  public function edit($uuid) {
    $permohonan = Permohonan::with('kontrak')->where('uuid', $uuid)->first();
    return response()->json([
      'data' => $permohonan
    ]);
  }

  public function show($uuid) {
    $permohonan = Permohonan::with(['user'])->where('uuid', $uuid)->first();
    return response()->json([
      'data' => $permohonan
    ]);
  }

  public function update(Request $request, $uuid) {
    $dataPermohonan = $request->validate([
      'industri' => 'required',
      'alamat' => 'required',
      'kegiatan' => 'required',
      'keterangan' => 'nullable',
      'jenis_contoh_id' => 'nullable',
    ]);
    $permohonan = Permohonan::findByUuid($uuid);

    // if ($permohonan['is_mandiri'] == 1) {
    $permohonan->update($dataPermohonan);
    return response()->json([
      'permohonan' => $permohonan,
      'message' => 'Data berhasil diubah.'
    ]);
    // }

    // $dataKontrak = $request->validate([
    //   'nomor_surat' => 'required_if:is_mandiri,0',
    //   'dokumen_permohonan' => 'required_if:is_mandiri,0|mimes:pdf|max:2000',
    //   'perihal' => 'required_if:is_mandiri,0',
    //   'tanggal_surat' => 'required_if:is_mandiri,0',
    //   'bulan' => 'required_if:is_mandiri,0|array',
    // ]);

    // if ($permohonan['is_mandiri'] == 0) {
    //   $kontrakId = $permohonan['kontrak_id'];
    //   $kontrak = Kontrak::where('id', $kontrakId)->first();

    //   if ($request->hasFile('dokumen_permohonan')) {
    //     if ($kontrak->dokumen_permohonan) {
    //       Storage::disk('public')->delete($kontrak->dokumen_permohonan);
    //     }
    //     $dataKontrak['dokumen_permohonan'] = $request->file('dokumen_permohonan')->store('dokumen-permohonan', 'public');
    //   }

    //   $permohonan->update($dataPermohonan);
    //   $kontrak->update($dataKontrak);

    //   return response()->json([
    //     'permohonan' => $permohonan,
    //     'kontrak' => $kontrak,
    //     'message' => 'Data berhasil diubah.'
    //   ]);
    // }

    // return response()->json(['message' => 'Error'], 422);
  }

  public function destroy($uuid) {
    $permohonan = Permohonan::findByUuid($uuid);

    // if ($permohonan['is_mandiri'] == 0) {
    //   $kontrakId = $permohonan['kontrak_id'];
    //   $kontrak = Kontrak::find($kontrakId);

    //   if ($kontrak->dokumen_permohonan) {
    //     Storage::disk('public')->delete($kontrak->dokumen_permohonan);
    //   }

    //   $kontrak->delete();
    // }

    $permohonan->delete();

    return response()->json([
      'message' => 'Data berhasil dihapus.',
    ]);
  }
}
