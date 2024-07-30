<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\FAQ;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FAQController extends Controller
{
    public function get()
    {
        return response()->json([
            'message' => 'Data berhasil ditemukan',
            'data' => FAQ::get()
        ]);
    }

    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = FAQ::where(function ($q) use ($request) {
                $q->where('pertanyaan', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('jawaban', 'LIKE', '%' . $request->search . '%');
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
                'pertanyaan' => 'required',
                'jawaban' => 'required',
                'pertanyaan_en' => 'required',
                'jawaban_en' => 'required',
                'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $data = $request->all();

            if ($request->hasFile('gambar')) {
                $data['gambar'] = '/storage/' . $request->file('gambar')->store('faq', 'public');
            }

            if ($faq = FAQ::create($data)) {
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
            $data = FAQ::findByUuid($uuid);

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
                'pertanyaan' => 'required',
                'jawaban' => 'required',
                'pertanyaan_en' => 'required',
                'jawaban_en' => 'required',
                'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $faq = FAQ::findByUuid($uuid);

            if (!$faq) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $data = $request->all();

            if ($faq->gambar != null && $faq->gambar != '') {
                $old = str_replace('/storage/', '', $faq->gambar);
                Storage::disk('public')->delete($old);
            }

            if ($request->hasFile('gambar')) {
                $data['gambar'] = '/storage/' . $request->file('gambar')->store('faq', 'public');
            } else {
                $data['gambar'] = null;
            }

            if ($faq->update($data)) {
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
            $faq = FAQ::findByUuid($uuid);

            if (!$faq) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            // Remove gambar
            if ($faq->gambar != null && $faq->gambar != '') {
                $old = str_replace('/storage/', '', $faq->gambar);
                Storage::disk('public')->delete($old);
            }

            $faq->delete();

            return response()->json([
                'message' => 'Data berhasil dihapus',
                'data' => $faq
            ]);
        } else {
            return abort(404);
        }
    }
}
