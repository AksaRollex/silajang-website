<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Paket;

class PaketController extends Controller
{
    public function get()
    {
        return response()->json([
            'message' => 'Data berhasil ditemukan',
            'data' => Paket::with(['parameters'])->get()
        ]);
    }

    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = Paket::where(function ($q) use ($request) {
                $q->where('nama', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('harga', 'LIKE', '%' . $request->search . '%');
            })->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

            return response()->json($data);
        } else {
            return abort(404);
        }
    }

    public function store(Request $request)
    {
        if (request()->wantsJson()) {
            $request->validate([
                'nama' => 'required',
                'harga' => 'required',
            ]);

            $data = $request->all();
            $data['harga'] = AppHelper::unrupiah($data['harga']);

            if (Paket::create($data)) {
                return response()->json([
                    'message' => 'Data berhasil disimpan',
                    'data' => $data
                ]);
            }
        } else {
            return abort(404);
        }
    }

    public function edit($uuid)
    {
        if (request()->wantsJson()) {
            $data = Paket::findByUuid($uuid);

            if (!$data) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'message' => 'Data berhasil ditemukan',
                'data' => $data
            ]);
        } else {
            return abort(404);
        }
    }

    public function update(Request $request, $uuid)
    {
        if (request()->wantsJson()) {
            $request->validate([
                'nama' => 'required',
                'harga' => 'required',
            ]);

            $paket = Paket::findByUuid($uuid);

            if (!$paket) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $data = $request->all();
            $data['harga'] = AppHelper::unrupiah($data['harga']);

            if ($paket->update($data)) {
                return response()->json([
                    'message' => 'Data berhasil diubah',
                    'data' => $paket
                ]);
            }
        } else {
            return abort(404);
        }
    }

    public function destroy($uuid)
    {
        if (request()->wantsJson()) {
            try {
                $paket = Paket::findByUuid($uuid);

                if (!$paket) {
                    return response()->json([
                        'message' => 'Data tidak ditemukan'
                    ], 404);
                }

                $paket->delete();

                return response()->json([
                    'message' => 'Data berhasil dihapus',
                    'data' => $paket
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => 'Paket tidak dapat dihapus karena digunakan pada data lain.'
                ], 500);
            }
        } else {
            return abort(404);
        }
    }
}
