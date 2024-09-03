<?php

namespace App\Http\Controllers;

use App\Models\TandaTangan;
use App\Models\TitikPermohonan;
use App\Models\TrackingPengujian;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\FontMetrics;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalisController extends Controller
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
                if ($request->status == 3) {
                    $q->where('status', 3);
                } else {
                    $q->where('status', '>', 3);
                }
            })->whereHas('parameters', function ($q) {
                if (!auth()->user()->hasRole(['admin', 'kepala-upt'])) {
                    $q->whereIn('parameters.id', auth()->user()->parameters()->pluck('parameters.id')->toArray());
                }
            })->whereYear('created_at', $request->tahun)->orderBy('kode', 'desc')->paginate($per, ['titik_permohonans.*', DB::raw('@no := @no + 1 AS no')]);

            $data->map(function ($a) {
                if (auth()->user()->hasRole(['admin', 'kepala-upt', 'koordinator-administrasi', 'koordinator-teknis'])) {
                    return $a->parameters()->orderByPivot(null ?? 'id')->get();
                }

                $allowedParams = auth()->user()->parameters()->pluck('parameters.id')->toArray();
                $params = $a->parameters()->whereIn('parameter_id', $allowedParams)->get();
                
                $acc = $params->every(function ($param) {
                    return $param->pivot->acc_analis == 1;
                });
                
                $a->check_param = $acc;
            });

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
        $data['parameters'] = $titik->getParamsByUser('acc_analis', ['admin', 'kepala-upt']);

        return response()->json([
            'data' => $data,
            'status' => 'success',
        ]);
    }

    public function fillParameter(Request $request, $uuid)
    {
        $request->validate([
            'parameter_uuid' => 'required',
            'hasil_uji' => 'required',
            'keterangan' => 'nullable',
        ]);

        $titik = TitikPermohonan::where('uuid', $uuid)->first();
        $parameter = $titik->parameters()->where('uuid', $request->parameter_uuid)->first();
        $titik->parameters()->updateExistingPivot($parameter->id, [
            'hasil_uji' => $request->hasil_uji,
            'hasil_uji_pembulatan' => $request->hasil_uji,
            'keterangan' => $request->keterangan,
            'acc_analis' => 1,
            'acc_analis_at' => now(),
        ]);

        $titik->checkAnalis();
        $titik->update(['can_upload' => 1]);

        return response()->json([
            'status' => 'success',
            'data' => $titik->parameters()->where('uuid', $request->parameter_uuid)->first(),
        ]);
    }
}
