<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LiburCuti;

class LiburCutiController extends Controller
{
    public function get()
    {
        return response()->json([
            'message' => 'Data berhasil ditemukan',
            'data' => LiburCuti::get()
        ]);
    }

    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = LiburCuti::where(function ($q) use ($request) {
                $q->where('tanggal', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('keterangan', 'LIKE', '%' . $request->search . '%');
            })->orderBy('tanggal')->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

            return response()->json($data);
        } else {
            return abort(404);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tanggal' => 'required',
            'keterangan' => 'required',
        ]);

        $data = $request->all();
        if ($libur = LiburCuti::create($data)) {
            return response()->json([
                'message' => 'Data berhasil disimpan.',
            ]);
        }
    }

    public function edit($uuid)
    {
        $libur = LiburCuti::findByUuid($uuid);
        return response()->json([
            'data' => $libur
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $this->validate($request, [
            'tanggal' => 'required',
            'keterangan' => 'required',
        ]);

        $data = $request->all();
        $libur = LiburCuti::findByUuid($uuid);
        if ($libur->update($data)) {
            return response()->json([
                'message' => 'Data berhasil diubah.',
            ]);
        }
    }

    public function destroy($uuid)
    {
        $libur = LiburCuti::findByUuid($uuid);
        if ($libur->delete()) {
            return response()->json([
                'message' => 'Data berhasil dihapus.',
            ]);
        }
    }
}
