<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class RoleController extends Controller
{
    public function get()
    {
        return response()->json([
            'message' => 'Data berhasil ditemukan',
            'data' => Role::get()
        ]);
    }

    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = Role::where(function ($q) use ($request) {
                $q->where('full_name', 'LIKE', '%' . $request->search . '%');
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
                'full_name' => 'required',
            ]);

            $data = $request->only('full_name');
            $data['guard_name'] = 'api';

            $role = new Role();
            $role->full_name = $data['full_name'];
            $role->guard_name = $data['guard_name'];
            $role->save();

            return response()->json([
                'message' => 'Data berhasil disimpan',
                'data' => $data
            ]);
        } else {
            return abort(404);
        }
    }

    public function edit($name)
    {
        if (request()->wantsJson()) {
            $data = Role::findByName($name);

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

    public function update(Request $request, $name)
    {
        if (request()->wantsJson()) {
            $request->validate([
                'full_name' => 'required',
            ]);

            $data = Role::findByName($name);

            if (!$data) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $data->update($request->only('full_name'));

            return response()->json([
                'message' => 'Data berhasil diubah',
                'data' => $data
            ]);
        } else {
            return abort(404);
        }
    }

    public function destroy($name)
    {
        if (request()->wantsJson()) {
            $data = Role::findByName($name);

            if (!$data) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $data->delete();

            return response()->json([
                'message' => 'Data berhasil dihapus',
                'data' => $data
            ]);
        } else {
            return abort(404);
        }
    }
}
