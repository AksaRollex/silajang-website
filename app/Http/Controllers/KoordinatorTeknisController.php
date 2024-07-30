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

class KoordinatorTeknisController extends Controller
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
                if ($request->status == 5) {
                    $q->where('status', 5);
                } else {
                    $q->where('status', '>', 5);
                }
            })->whereHas('parameters', function ($q) {
                if (!auth()->user()->hasRole(['admin', 'kepala-upt', 'koordinator-teknis'])) {
                    $q->whereIn('parameters.id', auth()->user()->parameters()->pluck('parameters.id')->toArray());
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
        $data['parameters'] = $titik->getParamsByUser('acc_manager', ['admin', 'kepala-upt', 'koordinator-teknis']);

        return response()->json([
            'data' => $data,
            'status' => 'success',
        ]);
    }

    public function fillParameter(Request $request, $uuid)
    {
        $request->validate([
            'parameter_uuid' => 'required',
            'hasil_uji_pembulatan' => 'nullable',
            'baku_mutu' => 'nullable',
            'mdl' => 'nullable',
            'satuan' => 'nullable',
            'keterangan' => 'nullable',
            'keterangan_hasil' => 'required',
        ]);

        $titik = TitikPermohonan::where('uuid', $uuid)->first();
        $parameter = $titik->parameters()->where('uuid', $request->parameter_uuid)->first();
        $titik->parameters()->updateExistingPivot($parameter->id, [
            'hasil_uji_pembulatan' => $request->hasil_uji_pembulatan,
            'baku_mutu' => $request->baku_mutu,
            'mdl' => $request->mdl,
            'satuan' => $request->satuan,
            'keterangan' => $request->keterangan,
            'keterangan_hasil' => $request->keterangan_hasil,
            'acc_manager' => 1,
            'acc_manager_at' => now(),
        ]);

        $titik->checkManager();

        return response()->json([
            'status' => 'success',
            'data' => $titik->parameters()->where('uuid', $request->parameter_uuid)->first(),
        ]);
    }

    public function reject(Request $request, $uuid)
    {
        $request->validate([
            'parameter_uuid' => 'required',
        ]);

        $titik = TitikPermohonan::where('uuid', $uuid)->first();
        $parameter = $titik->parameters()->where('uuid', $request->parameter_uuid)->first();
        $titik->parameters()->updateExistingPivot($parameter->id, [
            'acc_analis' => 0,
            'acc_analis_at' => null,
            'acc_manager' => 0,
            'acc_manager_at' => null,
        ]);

        $titik->checkManager();
        $titik->checkAnalis();

        return response()->json([
            'status' => $titik->status,
            'data' => $titik->parameters()->where('uuid', $request->parameter_uuid)->first(),
            'message' => 'Parameter ' . $parameter->nama . ' ditolak, silahkan cek kembali di Analis',
        ]);
    }
}
