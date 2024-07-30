<?php

namespace App\Http\Controllers;

use App\Models\KeteranganUmpanBalik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeteranganUmpanBalikController extends Controller
{
    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = KeteranganUmpanBalik::where(function ($q) use ($request) {
                $q->where('kode', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('keterangan', 'LIKE', '%' . $request->search . '%');
            })->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

            return response()->json($data);
        } else {
            return abort(404);
        }
    }

    public function update(Request $request, $uuid)
    {
        $request->validate([
            'keterangan' => 'required',
        ]);

        $data = KeteranganUmpanBalik::where('uuid', $uuid)->first();
        $data->keterangan = $request->keterangan;
        $data->save();

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function show()
    {
        if (request()->wantsJson()) {
            return response()->json(KeteranganUmpanBalik::get());
        } else {
            return abort(404);
        }
    }
}
