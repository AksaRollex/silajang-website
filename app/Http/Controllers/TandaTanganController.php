<?php

namespace App\Http\Controllers;

use App\Models\TandaTangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TandaTanganController extends Controller
{
    public function get()
    {
        return response()->json([
            'data' => TandaTangan::with('user')->whereHas('user', function ($q) {
                $q->where('nik', '!=', NULL);
            })->get()
        ]);
    }

    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = TandaTangan::with(['user.detail'])->where(function ($q) use ($request) {
                $q->where('bagian', 'LIKE', '%' . $request->search . '%');
                $q->orWhereHas('user', function ($q) use ($request) {
                    $q->where('nama', 'LIKE', '%' . $request->search . '%');
                    $q->orWhere('nip', 'LIKE', '%' . $request->search . '%');
                    $q->orWhereHas('roles', function ($q) use ($request) {
                        $q->where('name', 'LIKE', '%' . $request->search . '%');
                        $q->orWhere('full_name', 'LIKE', '%' . $request->search . '%');
                    });
                });
            })->orderBy('bagian')->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

            return response()->json($data);
        } else {
            return abort(404);
        }
    }

    public function edit($uuid)
    {
        $data = TandaTangan::findByUuid($uuid);
        return response()->json([
            'data' => $data
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $request->validate([
            'bagian' => 'required',
            'user_id' => 'required',
        ]);

        $data = TandaTangan::findByUuid($uuid);
        $data->update($request->only(['user_id']));
        return response()->json([
            'message' => 'Data berhasil diubah',
        ]);
    }
}
