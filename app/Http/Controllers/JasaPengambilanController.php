<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\JasaPengambilan;

class JasaPengambilanController extends Controller
{
    public function get()
    {
        return response()->json([
            'message' => 'Data berhasil ditemukan',
            'data' => JasaPengambilan::get()
        ]);
    }

    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = JasaPengambilan::where(function ($q) use ($request) {
                $q->where('wilayah', 'LIKE', '%' . $request->search . '%');
            })->orderBy('wilayah')->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

            return response()->json($data);
        } else {
            return abort(404);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'wilayah' => 'required',
            'harga' => 'required',
        ]);

        $data = $request->all();
        $data['harga'] = AppHelper::unrupiah($request->harga);

        if ($jasa = JasaPengambilan::create($data)) {
            return response()->json([
                'message' => 'Data berhasil disimpan.',
            ]);
        }
    }

    public function edit($uuid)
    {
        $jasa = JasaPengambilan::findByUuid($uuid);
        return response()->json([
            'data' => $jasa
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $this->validate($request, [
            'wilayah' => 'required',
            'harga' => 'required',
        ]);

        $data = $request->all();
        $data['harga'] = AppHelper::unrupiah($request->harga);

        $jasa = JasaPengambilan::findByUuid($uuid);
        if ($jasa->update($data)) {
            return response()->json([
                'message' => 'Data berhasil diubah.',
            ]);
        }
    }

    public function destroy($uuid)
    {
        $jasa = JasaPengambilan::findByUuid($uuid);
        if ($jasa->delete()) {
            return response()->json([
                'message' => 'Data berhasil dihapus.',
            ]);
        }
    }
}
