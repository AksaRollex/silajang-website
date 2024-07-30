<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use App\Models\Paket;
use App\Models\PaketParameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaketParameterController extends Controller
{
    public function index(Request $request, $uuid)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = Parameter::with(['pakets' => function ($q) use ($uuid) {
                $q->where('pakets.uuid', $uuid);
            }])->where(function ($q) use ($request) {
                $q->where('nama', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('satuan', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('metode', 'LIKE', '%' . $request->search . '%');
            })->whereHas('pakets', function ($q) use ($uuid) {
                $q->where('pakets.uuid', $uuid);
            })->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

            return response()->json($data);
        } else {
            return abort(404);
        }
    }

    public function get($paket)
    {
        if (request()->wantsJson()) {
            $data = PaketParameter::with(['parameter'])->get()->pluck('parameter.uuid');

            return response()->json([
                'message' => 'Data berhasil ditemukan',
                'data' => $data
            ]);
        } else {
            return abort(404);
        }
    }

    public function store(Request $request, $paket)
    {
        $request->validate([
            'uuid' => 'required|exists:parameters,uuid'
        ]);

        $paket = Paket::findByUuid($paket);
        $parameter = Parameter::findByUuid($request->uuid);

        $check = PaketParameter::where('parameter_id', $parameter->id)->first();
        if ($check) {
            return response()->json([
                'message' => 'Parameter sudah ada di Paket ' . $check->paket->nama
            ], 400);
        }

        $paket->parameters()->attach($parameter->id);

        return response()->json([
            'message' => 'Parameter berhasil ditambahkan',
        ]);
    }

    public function destroy(Request $request, $paket)
    {
        $request->validate([
            'uuid' => 'required|exists:parameters,uuid'
        ]);

        $paket = Paket::findByUuid($paket);
        $parameter = Parameter::findByUuid($request->uuid);

        $paket->parameters()->detach($parameter->id);

        return response()->json([
            'message' => 'Parameter berhasil dihapus',
        ]);
    }
}
