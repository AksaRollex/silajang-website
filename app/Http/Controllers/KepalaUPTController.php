<?php

namespace App\Http\Controllers;

use App\Models\TandaTangan;
use App\Models\TitikPermohonan;
use App\Models\TrackingPengujian;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\FontMetrics;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KepalaUPTController extends Controller
{
    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = TitikPermohonan::with(['permohonan.user'])->without(['parameters', 'jenisWadahs'])->where(function ($q) use ($request) {
                $q->where('kode', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('lokasi', 'LIKE', '%' . $request->search . '%');
            })->where(function ($q) use ($request) {
                if ($request->status == 7) {
                    $q->where('status', 7);
                } else {
                    $q->where('status', '>', 7);
                }
            })->whereYear('created_at', $request->tahun)->orderBy('kode', 'desc')->paginate($per, ['titik_permohonans.*', DB::raw('@no := @no + 1 AS no')]);

            return response()->json($data);
        } else {
            return abort(404);
        }
    }

    public function show($uuid)
    {
        $titik = TitikPermohonan::with(['permohonan' => function ($q) {
            $q->with(['jasaPengambilan', 'user.detail']);
        }, 'peraturan', 'parameters' => function ($q) {
            $q->orderBy('is_dapat_diuji');
        }, 'acuanMetode'])->where('uuid', $uuid)->first();

        if (!$titik) {
            return abort(404);
        }

        $data = collect($titik)->forget('parameters');
        $data['parameters'] = $titik->getParamsByUser('acc_manager');

        return response()->json([
            'data' => $data,
            'status' => 'success',
        ]);
    }

    public function verify($uuid)
    {
        $titik = TitikPermohonan::findByUuid($uuid);

        if (!$titik) {
            return abort(404);
        }

        if ($titik->status_pembayaran == 1 || $titik->permohonan->user->golongan_id == 2) {
            $titik->update([
                'status' => 9,
            ]);
            TrackingPengujian::create(['titik_permohonan_id' => $titik->id, 'status' => 8]);
            TrackingPengujian::create(['titik_permohonan_id' => $titik->id, 'status' => 9]);
        } else {
            $titik->update([
                'status' => 8,
            ]);
            TrackingPengujian::create(['titik_permohonan_id' => $titik->id, 'status' => 8]);
        }

        return response()->json([
            'message' => 'LHU berhasil diverifikasi',
            'status' => 'success',
        ]);
    }

    public function rollback($uuid)
    {
        $titik = TitikPermohonan::findByUuid($uuid);

        if (!$titik) {
            return abort(404);
        }

        $titik->update([
            'status' => 7,
        ]);

        TrackingPengujian::create(['titik_permohonan_id' => $titik->id, 'status' => 7]);

        return response()->json([
            'message' => 'LHU berhasil dikembalikan',
            'status' => 'success',
        ]);
    }
}
