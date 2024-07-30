<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProdukHukum;
use Illuminate\Support\Facades\Storage;

class ProdukHukumController extends Controller
{
    public function get()
    {
        return response()->json([
            'message' => 'Data berhasil ditemukan',
            'data' => ProdukHukum::get()
        ]);
    }

    public function show($slug)
    {
        $produk = ProdukHukum::with(['items'])->where('slug', $slug)->first();
        return response()->json([
            'message' => 'Data berhasil ditemukan',
            'data' => $produk
        ]);
    }

    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = ProdukHukum::where(function ($q) use ($request) {
                $q->where('nama', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('deskripsi', 'LIKE', '%' . $request->search . '%');
            })->orderBy('created_at', 'desc')->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

            return response()->json($data);
        } else {
            return abort(404);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'deskripsi' => 'nullable',
            'items' => 'required|array|min:1',
            'items.*.nama' => 'required',
            'items.*.file' => 'required|file|mimes:pdf'
        ]);

        $data = $request->all();
        if ($produk = ProdukHukum::create($data)) {
            foreach ($data['items'] as $item) {
                $item['produk_hukum_id'] = $produk->id;
                $item['file'] = '/storage/' . $item['file']->store('produk_hukum', 'public');
                $produk->items()->create($item);
            }

            return response()->json([
                'message' => 'Data berhasil disimpan.',
            ]);
        }
    }

    public function edit($uuid)
    {
        $produk = ProdukHukum::with(['items'])->where('uuid', $uuid)->first();
        return response()->json([
            'data' => $produk
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $this->validate($request, [
            'nama' => 'required',
            'deskripsi' => 'nullable',
            'items' => 'required|array|min:1',
            'items.*.nama' => 'required',
            'items.*.file' => 'nullable|file|mimes:pdf'
        ]);

        $data = $request->all();
        $produk = ProdukHukum::findByUuid($uuid);
        if ($produk->update($data)) {
            foreach ($produk->items as $item) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $item->file));
                $item->delete();
            }

            foreach ($data['items'] as $item) {
                $item['produk_hukum_id'] = $produk->id;
                $item['file'] = '/storage/' . $item['file']->store('produk_hukum', 'public');
                $produk->items()->create($item);
            }

            return response()->json([
                'message' => 'Data berhasil diubah.',
            ]);
        }
    }

    public function destroy($uuid)
    {
        $produk = ProdukHukum::findByUuid($uuid);
        $items = $produk->items;
        if ($produk->delete()) {
            foreach ($items as $item) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $item->file));
            }

            return response()->json([
                'message' => 'Data berhasil dihapus.',
            ]);
        }
    }

    public function uploadImage(Request $request) // For CKEditor
    {
        $file = 'storage/' . $request->upload->store('produk-hukum', 'public');
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
