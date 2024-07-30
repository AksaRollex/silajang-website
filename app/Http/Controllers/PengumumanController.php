<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    public function get()
    {
        return response()->json([
            'message' => 'Data berhasil ditemukan',
            'data' => Pengumuman::get()
        ]);
    }

    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = Pengumuman::where(function ($q) use ($request) {
                $q->where('judul', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('isi', 'LIKE', '%' . $request->search . '%');
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
                'judul' => 'required',
                'isi' => 'required',
                'judul_en' => 'required',
                'isi_en' => 'required',
            ]);

            $data = $request->all();

            if ($pengumuman = Pengumuman::create($data)) {
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
            $data = Pengumuman::findByUuid($uuid);

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
                'judul' => 'required',
                'isi' => 'required',
                'judul_en' => 'required',
                'isi_en' => 'required',
            ]);

            $pengumuman = Pengumuman::findByUuid($uuid);

            if (!$pengumuman) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $data = $request->all();

            if ($pengumuman->update($data)) {
                return response()->json([
                    'message' => 'Data berhasil diubah',
                    'data' => $data
                ]);
            }
        } else {
            return abort(404);
        }
    }

    public function destroy($uuid)
    {
        if (request()->wantsJson()) {
            $pengumuman = Pengumuman::findByUuid($uuid);

            if (!$pengumuman) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $pengumuman->delete();

            return response()->json([
                'message' => 'Data berhasil dihapus',
                'data' => $pengumuman
            ]);
        } else {
            return abort(404);
        }
    }
}
