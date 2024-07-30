<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Permohonan;

class PermohonanController extends Controller
{
    public function get()
    {
        return response()->json([
            'message' => 'Data berhasil ditemukan',
            'data' => Permohonan::get()
        ]);
    }

    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = Permohonan::with(['jasaPengambilan'])->where(function ($q) use ($request) {
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

    public function store(Request $request)
    {
        if (auth()->user()->has_tagihan) {
            return response()->json([
                'message' => 'Anda masih memiliki tagihan yang belum dibayar. Silahkan selesaikan pembayaran terlebih dahulu.',
            ], 422);
        }

        $this->validate($request, [
            'industri' => 'required',
            'alamat' => 'required',
            'kegiatan' => 'required',
            'keterangan' => 'nullable',
            'pembayaran' => 'required|in:tunai,transfer',
            'is_mandiri' => 'required|in:0,1',
            'jasa_pengambilan_id' => 'required_if:is_mandiri,0',
            'jenis_contoh_id' => 'nullable',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        if ($request->is_mandiri == 1) {
            $data['jasa_pengambilan_id'] = null;
        }

        if ($permohonan = Permohonan::create($data)) {
            return response()->json([
                'message' => 'Data berhasil disimpan.',
                'data' => $permohonan
            ]);
        }
    }

    public function edit($uuid)
    {
        $permohonan = Permohonan::findByUuid($uuid);
        return response()->json([
            'data' => $permohonan
        ]);
    }

    public function show($uuid)
    {
        $permohonan = Permohonan::with(['user'])->where('uuid', $uuid)->first();
        return response()->json([
            'data' => $permohonan
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $this->validate($request, [
            'industri' => 'required',
            'alamat' => 'required',
            'kegiatan' => 'required',
            'keterangan' => 'nullable',
            'jenis_contoh_id' => 'nullable',
        ]);

        $data = $request->only([
            'industri',
            'alamat',
            'kegiatan',
            'keterangan',
            'jenis_contoh_id',
        ]);
        $permohonan = Permohonan::findByUuid($uuid);
        if ($permohonan->update($data)) {
            return response()->json([
                'message' => 'Data berhasil diubah.',
            ]);
        }
    }

    public function destroy($uuid)
    {
        $permohonan = Permohonan::findByUuid($uuid);
        if ($permohonan->delete()) {
            return response()->json([
                'message' => 'Data berhasil dihapus.',
            ]);
        }
    }
}
