<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KecamatanController extends Controller
{
    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = Kecamatan::with(['kab_kota'])->where(function ($q) use ($request) {
                $q->where('nama', 'LIKE', '%' . $request->search . '%');
                $q->orWhereHas('kab_kota', function ($q) use ($request) {
                    $q->where('nama', 'LIKE', "$request->search");
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
            'kab_kota_id' => 'required'
        ]);

        $data = $request->all();
        if (Kecamatan::create($data)) {
            return response()->json([
                'message' => 'Data berhasil disimpan.',
            ]);
        }
    }

    public function edit($uuid)
    {
        $data = Kecamatan::findByUuid($uuid);
        return response()->json([
            'data' => $data
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $this->validate($request, [
            'nama' => 'required',
            'kab_kota_id' => 'required'
        ]);

        $data = $request->all();
        $Kecamatan = Kecamatan::findByUuid($uuid);
        if ($Kecamatan->update($data)) {
            return response()->json([
                'message' => 'Data berhasil diubah.',
            ]);
        }
    }

    public function destroy($uuid)
    {
        $data = Kecamatan::findByUuid($uuid);
        if ($data->delete()) {
            return response()->json([
                'message' => 'Data berhasil dihapus.',
            ]);
        }
    }

    public function get($kid)
    {
        $kecamatan = Kecamatan::where('kab_kota_id', $kid)->get();
        return response()->json([
            'success' => true,
            'message' => 'Daftar data kecamatan',
            'data' => $kecamatan
        ], 200);
    }

    public function show($id)
    {
        $kecamatan = Kecamatan::find($id);

        if ($kecamatan) {
            return response()->json([
                'success' => true,
                'message' => 'Detail data kecamatan',
                'data' => $kecamatan
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data kecamatan tidak ditemukan',
                'data' => ''
            ], 404);
        }
    }
}
