<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LayananController extends Controller
{
    public function get()
    {
        return response()->json([
            'message' => 'Data berhasil ditemukan',
            'data' => Layanan::get()
        ]);
    }

    public function show($slug)
    {
        $data = Layanan::where('slug', $slug)->first();

        if (!$data) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Data berhasil ditemukan',
            'data' => $data
        ]);
    }

    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = Layanan::where(function ($q) use ($request) {
                $q->where('nama', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('deskripsi', 'LIKE', '%' . $request->search . '%');
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
                'deskripsi' => 'required',
                'nama_en' => 'required',
                'deskripsi_en' => 'required',
            ]);

            $data = $request->all();

            if ($layanan = Layanan::create($data)) {
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
            $data = Layanan::findByUuid($uuid);

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
                'deskripsi' => 'required',
                'nama_en' => 'required',
                'deskripsi_en' => 'required',
            ]);

            $layanan = Layanan::findByUuid($uuid);

            if (!$layanan) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $data = $request->all();

            if ($layanan->update($data)) {
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
            $layanan = Layanan::findByUuid($uuid);

            if (!$layanan) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            // Delete image inside description
            $pattern = '/<img\s+src="([^"]+)"/';

            preg_match_all($pattern, $layanan->deskripsi, $matches);
            $imgSrcList = $matches[1];
            foreach ($imgSrcList as $src) {
                if (file_exists(storage_path('app/public/' . str_replace(getenv('APP_URL') . '/storage/', '', $src)))) {
                    unlink(storage_path('app/public/' . str_replace(getenv('APP_URL') . '/storage/', '', $src)));
                }
            }

            preg_match_all($pattern, $layanan->deskripsi_en, $matches);
            $imgSrcList = $matches[1];
            foreach ($imgSrcList as $src) {
                if (file_exists(storage_path('app/public/' . str_replace(getenv('APP_URL') . '/storage/', '', $src)))) {
                    unlink(storage_path('app/public/' . str_replace(getenv('APP_URL') . '/storage/', '', $src)));
                }
            }

            $layanan->delete();

            return response()->json([
                'message' => 'Data berhasil dihapus',
                'data' => $layanan
            ]);
        } else {
            return abort(404);
        }
    }

    public function uploadImage(Request $request) // For CKEditor
    {
        $file = 'storage/' . $request->upload->store('layanan', 'public');
        return response()->json([
            'url' => asset($file)
        ]);
    }

    public function removeImage(Request $request) // For CKEditor
    {
        foreach ($request->image as $image) {
            if (file_exists(storage_path('app/public/' . str_replace(getenv('APP_URL') . '/storage/', '', $image)))) {
                unlink(storage_path('app/public/' . str_replace(getenv('APP_URL') . '/storage/', '', $image)));
            }
        }
    }
}
