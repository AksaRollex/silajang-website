<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Peraturan;
use Illuminate\Support\Facades\Storage;

class PeraturanController extends Controller
{
    public function get()
    {
        return response()->json([
            'message' => 'Data berhasil ditemukan',
            'data' => Peraturan::get()
        ]);
    }

    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = Peraturan::where(function ($q) use ($request) {
                $q->where('nama', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('nomor', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('tentang', 'LIKE', '%' . $request->search . '%');
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
                'nomor' => 'required',
                'tentang' => 'required',
                'file' => 'nullable|file|mimes:pdf',
            ]);

            $data = $request->all();

            if ($request->hasFile('file')) {
                $data['file'] = '/storage/' . $request->file('file')->store('peraturan', 'public');
            }

            if (Peraturan::create($data)) {
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
            $data = Peraturan::findByUuid($uuid);

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
                'nomor' => 'required',
                'tentang' => 'required',
                'file' => 'nullable|file|mimes:pdf',
            ]);

            $peraturan = Peraturan::findByUuid($uuid);

            if (!$peraturan) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $data = $request->all();

            if ($peraturan->file != null && $peraturan->file != '') {
                $old = str_replace('/storage/', '', $peraturan->file);
                Storage::disk('public')->delete($old);
            }

            if ($request->hasFile('file')) {
                $data['file'] = '/storage/' . $request->file('file')->store('peraturan', 'public');
            } else {
                $data['file'] = null;
            }

            if ($peraturan->update($data)) {
                return response()->json([
                    'message' => 'Data berhasil diubah',
                    'data' => $peraturan
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
                $peraturan = Peraturan::findByUuid($uuid);

                if (!$peraturan) {
                    return response()->json([
                        'message' => 'Data tidak ditemukan'
                    ], 404);
                }

                if ($peraturan->file != null && $peraturan->file != '') {
                    $old = str_replace('/storage/', '', $peraturan->file);
                    Storage::disk('public')->delete($old);
                }

                $peraturan->delete();

                return response()->json([
                    'message' => 'Data berhasil dihapus',
                    'data' => $peraturan
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => 'Peraturan tidak dapat dihapus karena digunakan pada data lain.'
                ], 500);
            }
        } else {
            return abort(404);
        }
    }
}
