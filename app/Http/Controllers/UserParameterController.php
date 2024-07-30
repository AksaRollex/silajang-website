<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserParameterController extends Controller
{
    public function index(Request $request, $uuid)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = Parameter::with(['users' => function ($q) use ($uuid) {
                $q->where('users.uuid', $uuid);
            }])->where(function ($q) use ($request) {
                $q->where('nama', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('satuan', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('metode', 'LIKE', '%' . $request->search . '%');
            })->whereHas('users', function ($q) use ($uuid) {
                $q->where('users.uuid', $uuid);
            })->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

            return response()->json($data);
        } else {
            return abort(404);
        }
    }

    public function get($user)
    {
        if (request()->wantsJson()) {
            $data = Parameter::whereHas('users', function ($q) use ($user) {
                $q->where('users.uuid', $user);
            })->pluck('uuid');

            return response()->json([
                'message' => 'Data berhasil ditemukan',
                'data' => $data
            ]);
        } else {
            return abort(404);
        }
    }

    public function store(Request $request, $user)
    {
        $request->validate([
            'uuid' => 'required|exists:parameters,uuid'
        ]);

        $user = User::findByUuid($user);
        $parameter = Parameter::findByUuid($request->uuid);

        $user->parameters()->attach($parameter->id);

        return response()->json([
            'message' => 'Parameter berhasil ditambahkan',
        ]);
    }

    public function destroy(Request $request, $user)
    {
        $request->validate([
            'uuid' => 'required|exists:parameters,uuid'
        ]);

        $user = User::findByUuid($user);
        $parameter = Parameter::findByUuid($request->uuid);

        $user->parameters()->detach($parameter->id);

        return response()->json([
            'message' => 'Parameter berhasil dihapus',
        ]);
    }
}
