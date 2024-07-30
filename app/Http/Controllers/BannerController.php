<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function get()
    {
        return response()->json([
            'message' => 'Data berhasil ditemukan',
            'data' => Banner::get()
        ]);
    }

    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = Banner::where(function ($q) use ($request) {
                $q->where('judul', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('link', 'LIKE', '%' . $request->search . '%');
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
                'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'link' => 'nullable',
            ]);

            $data = $request->all();
            $data['gambar'] = '/storage/' . $request->file('gambar')->store('banner', 'public');

            if ($banner = Banner::create($data)) {
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
            $data = Banner::findByUuid($uuid);

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
                'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'link' => 'nullable',
            ]);

            $banner = Banner::findByUuid($uuid);

            if (!$banner) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $data = $request->all();

            if ($banner->gambar != null && $banner->gambar != '') {
                $old = str_replace('/storage/', '', $banner->gambar);
                Storage::disk('public')->delete($old);
            }

            $data['gambar'] = '/storage/' . $request->file('gambar')->store('banner', 'public');

            if ($banner->update($data)) {
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
            $banner = Banner::findByUuid($uuid);

            if (!$banner) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            // Remove gambar
            if ($banner->gambar != null && $banner->gambar != '') {
                $old = str_replace('/storage/', '', $banner->gambar);
                Storage::disk('public')->delete($old);
            }

            $banner->delete();

            return response()->json([
                'message' => 'Data berhasil dihapus',
                'data' => $banner
            ]);
        } else {
            return abort(404);
        }
    }
}
