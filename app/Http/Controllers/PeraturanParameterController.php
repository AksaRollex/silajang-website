<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use App\Models\Peraturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeraturanParameterController extends Controller
{
    public function index(Request $request, $uuid)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = Parameter::with(['peraturans' => function ($q) use ($uuid) {
                $q->where('peraturans.uuid', $uuid);
            }])->where(function ($q) use ($request) {
                $q->where('nama', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('satuan', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('metode', 'LIKE', '%' . $request->search . '%');
            })->whereHas('peraturans', function ($q) use ($uuid) {
                $q->where('peraturans.uuid', $uuid);
            })->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

            return response()->json($data);
        } else {
            return abort(404);
        }
    }

    public function get($peraturan)
    {
        if (request()->wantsJson()) {
            $data = Parameter::whereHas('peraturans', function ($q) use ($peraturan) {
                $q->where('peraturans.uuid', $peraturan);
            })->pluck('uuid');

            return response()->json([
                'message' => 'Data berhasil ditemukan',
                'data' => $data
            ]);
        } else {
            return abort(404);
        }
    }

    public function store(Request $request, $peraturan)
    {
        $request->validate([
            'uuid' => 'required|exists:parameters,uuid'
        ]);

        $peraturan = Peraturan::findByUuid($peraturan);
        $parameter = Parameter::findByUuid($request->uuid);

        $peraturan->parameters()->attach($parameter->id);

        return response()->json([
            'message' => 'Parameter berhasil ditambahkan',
        ]);
    }

    public function update(Request $request, $peraturan)
    {
        $request->validate([
            'uuid' => 'required|exists:parameters,uuid',
            'baku_mutu' => 'string',
            'cetak_miring' => 'boolean',
        ]);

        // Update pivot table value
        $peraturan = Peraturan::findByUuid($peraturan);
        $parameter = Parameter::findByUuid($request->uuid);

        $data = $request->only(['baku_mutu', 'cetak_miring']);
        $peraturan->parameters()->updateExistingPivot($parameter->id, $data);

        return response()->json([
            'message' => 'Parameter berhasil diperbarui',
        ]);
    }

    public function destroy(Request $request, $peraturan)
    {
        $request->validate([
            'uuid' => 'required|exists:parameters,uuid'
        ]);

        $peraturan = Peraturan::findByUuid($peraturan);
        $parameter = Parameter::findByUuid($request->uuid);

        $peraturan->parameters()->detach($parameter->id);

        return response()->json([
            'message' => 'Parameter berhasil dihapus',
        ]);
    }
}
