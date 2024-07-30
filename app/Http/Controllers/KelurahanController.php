<?php

namespace App\Http\Controllers;

use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelurahanController extends Controller
{
    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = Kelurahan::with(['kecamatan.kab_kota'])->where(function ($q) use ($request) {
                $q->where('nama', 'LIKE', '%' . $request->search . '%');
                $q->orWhereHas('kecamatan', function ($q) use ($request) {
                    $q->where('nama', 'LIKE', "$request->search");
                    $q->orWhereHas('kab_kota', function ($q) use ($request) {
                        $q->where('nama', 'LIKE', "$request->search");
                    });
                });
            })->orderBy('nama')->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

            return response()->json($data);
        } else {
            return abort(404);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'kab_kota_id' => 'required',
            'kecamatan_id' => 'required'
        ]);

        $data = $request->all();
        if (Kelurahan::create($data)) {
            return response()->json([
                'message' => 'Data berhasil disimpan.',
            ]);
        }
    }

    public function edit($uuid)
    {
        $data = Kelurahan::findByUuid($uuid);
        return response()->json([
            'data' => $data
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $this->validate($request, [
            'nama' => 'required',
            'kab_kota_id' => 'required',
            'kecamatan_id' => 'required'
        ]);

        $data = $request->all();
        $Kelurahan = Kelurahan::findByUuid($uuid);
        if ($Kelurahan->update($data)) {
            return response()->json([
                'message' => 'Data berhasil diubah.',
            ]);
        }
    }

    public function destroy($uuid)
    {
        $data = Kelurahan::findByUuid($uuid);
        if ($data->delete()) {
            return response()->json([
                'message' => 'Data berhasil dihapus.',
            ]);
        }
    }

    public function get($pid)
    {
        $kelurahan = Kelurahan::where('kecamatan_id', $pid)->get();
        return response()->json([
            'success' => true,
            'message' => 'Daftar data kelurahan',
            'data' => $kelurahan
        ], 200);
    }

    public function show($pid, $id)
    {
        $kelurahan = Kelurahan::where('kecamatan_id', $pid)->where('id', $id)->first();

        if ($kelurahan) {
            return response()->json([
                'success' => true,
                'message' => 'Detail data kelurahan',
                'data' => $kelurahan
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data kelurahan tidak ditemukan',
                'data' => ''
            ], 404);
        }
    }
}
