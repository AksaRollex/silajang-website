<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RadiusPengambilan;

class RadiusPengambilanController extends Controller
{
    public function get()
    {
        return response()->json([
            'message' => 'Data berhasil ditemukan',
            'data' => RadiusPengambilan::get()
        ]);
    }

    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = RadiusPengambilan::where(function ($q) use ($request) {
                $q->where('nama', 'LIKE', '%' . $request->search . '%');
            })->orderBy('radius')->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

            return response()->json($data);
        } else {
            return abort(404);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'radius' => 'required',
            'harga' => 'required',
        ]);

        $data = $request->all();
        $data['harga'] = AppHelper::unrupiah($request->harga);
        $data['radius'] = AppHelper::unrupiah($request->radius);

        if ($radius = RadiusPengambilan::create($data)) {
            return response()->json([
                'message' => 'Data berhasil disimpan.',
            ]);
        }
    }

    public function edit($uuid)
    {
        $radius = RadiusPengambilan::findByUuid($uuid);
        return response()->json([
            'data' => $radius
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $this->validate($request, [
            'nama' => 'required',
            'radius' => 'required',
            'harga' => 'required',
        ]);

        $data = $request->all();
        $data['harga'] = AppHelper::unrupiah($request->harga);
        $data['radius'] = AppHelper::unrupiah($request->radius);

        $radius = RadiusPengambilan::findByUuid($uuid);
        if ($radius->update($data)) {
            return response()->json([
                'message' => 'Data berhasil diubah.',
            ]);
        }
    }

    public function destroy($uuid)
    {
        $radius = RadiusPengambilan::findByUuid($uuid);
        if ($radius->delete()) {
            return response()->json([
                'message' => 'Data berhasil dihapus.',
            ]);
        }
    }
}
