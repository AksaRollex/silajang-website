<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Permohonan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KontrakController extends Controller
{
    public function index (Request $request) {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = Permohonan::with(['kontrak'])->where(function ($q) use ($request) {
                $q->where('keterangan', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('industri', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('kegiatan', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('alamat', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('pembayaran', 'LIKE', '%' . $request->search . '%');
            })->where(function ($q) use ($request) {
                if ($request->kesimpulan_kontrak == 0) {
                    $q->where('kesimpulan_kontrak', 0);
                } else if ($request->kesimpulan_kontrak == 1) {
                    $q->where('kesimpulan_kontrak', 1);
                } else {
                    $q->where('kesimpulan_kontrak', 2);
                }
            })->wherenotNull('kontrak_id')->whereYear('created_at', $request->tahun)->orderBy('created_at', 'desc')->paginate($per, ['permohonans.*', DB::raw('@no := @no + 1 AS no')]);

            return response()->json($data);
        } else {
            return abort(404);
        }
    }

    public function show($uuid) {
        $permohonan = Permohonan::with(['user', 'kontrak'])->where('uuid', $uuid)->first();
        return response()->json([
            'data' => $permohonan,
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $request->validate(['kesimpulan_kontrak' => 'nullable']);
        $data = $request->only(['kesimpulan_kontrak']);
        $permohonan = Permohonan::where('uuid', $uuid)->first();

        if (!$permohonan) {
            return abort(404);
        }

        $permohonan->update($data);
        return response()->json(['status' => 'success']);
    }

    // public function downloadFile()
    // {

    // }
}
