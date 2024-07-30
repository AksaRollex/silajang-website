<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KabKota;

class KabKotaController extends Controller
{
    public function get()
    {
        return response()->json([
            'message' => 'Data berhasil ditemukan',
            'data' => KabKota::get()
        ]);
    }

    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = KabKota::where(function ($q) use ($request) {
                $q->where('nama', 'LIKE', '%' . $request->search . '%');
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
        ]);

        $data = $request->all();
        if (KabKota::create($data)) {
            return response()->json([
                'message' => 'Data berhasil disimpan.',
            ]);
        }
    }

    public function edit($uuid)
    {
        $data = KabKota::findByUuid($uuid);
        return response()->json([
            'data' => $data
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $this->validate($request, [
            'nama' => 'required',
        ]);

        $data = $request->all();
        $KabKota = KabKota::findByUuid($uuid);
        if ($KabKota->update($data)) {
            return response()->json([
                'message' => 'Data berhasil diubah.',
            ]);
        }
    }

    public function destroy($uuid)
    {
        $data = KabKota::findByUuid($uuid);
        if ($data->delete()) {
            return response()->json([
                'message' => 'Data berhasil dihapus.',
            ]);
        }
    }
}
