<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Parameter;

class ParameterController extends Controller
{
    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = Parameter::where(function ($q) use ($request) {
                $q->where('nama', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('satuan', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('metode', 'LIKE', '%' . $request->search . '%');
                // $q->orWhereHas('jenisParameter', function ($q) use ($request) {
                //     $q->where('nama', 'LIKE', '%' . $request->search . '%');
                //     $q->orWhereHas('sample', function ($q) use ($request) {
                //         $q->where('nama', 'LIKE', '%' . $request->search . '%');
                //     });
                // });
            })->when(isset($request->except), function ($q) use ($request) {
                $q->whereNotIn('parameters.uuid', $request->except);
            })->orderBy('nama')->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

            return response()->json($data);
        } else {
            return abort(404);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'metode' => 'required',
            'harga' => 'required',
            'satuan' => 'nullable',
            'mdl' => 'nullable',
            'is_akreditasi' => 'required',
            'pengawetan_ids' => 'required|array',
            'jenis_parameter_id' => 'required'
        ]);

        $data = $request->all();
        $data['harga'] = AppHelper::unrupiah($data['harga']);
        $data['mdl'] = str_replace(',', '.', $data['mdl']);

        if ($parameter = Parameter::create($data)) {
            $parameter->pengawetans()->sync($request->pengawetan_ids);
            return response()->json([
                'message' => 'Data berhasil disimpan.',
            ]);
        }
    }

    public function edit($uuid)
    {
        $parameter = Parameter::findByUuid($uuid);
        $parameter->pengawetan_ids = $parameter->pengawetans->pluck('id');

        return response()->json([
            'data' => $parameter
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $this->validate($request, [
            'nama' => 'required',
            'metode' => 'required',
            'harga' => 'required',
            'satuan' => 'nullable',
            'mdl' => 'nullable',
            'is_akreditasi' => 'required',
            'pengawetan_ids' => 'array',
            'jenis_parameter_id' => 'required',
        ]);

        $data = $request->all();
        $data['harga'] = AppHelper::unrupiah($data['harga']);
        $data['mdl'] = str_replace(',', '.', $data['mdl']);

        $parameter = Parameter::findByUuid($uuid);
        if ($parameter->update($data)) {
            $parameter->pengawetans()->sync($request->pengawetan_ids);
            return response()->json([
                'message' => 'Data berhasil diubah.',
            ]);
        }
    }

    public function destroy($uuid)
    {
        try {
            $parameter = Parameter::findByUuid($uuid);
            if ($parameter->delete()) {
                return response()->json([
                    'message' => 'Data berhasil dihapus.',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Parameter tidak dapat dihapus karena digunakan pada data lain.',
            ], 500);
        }
    }
}
