<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\TitikPermohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TrackingPengujianController extends Controller {
  public function index(Request $request) {
    if (request()->wantsJson()) {
      $per = (($request->per) ? $request->per : 10);
      $page = (($request->page) ? $request->page - 1 : 0);

      DB::statement('set @no=0+' . $page * $per);
      $data = TitikPermohonan::with(['permohonan.user', 'trackings'])->where(function ($q) use ($request) {
        $q->where('kode', 'LIKE', '%' . $request->search . '%');
        $q->orWhere('lokasi', 'LIKE', '%' . $request->search . '%');
        $q->orWhereHas('permohonan', function ($q) use ($request) {
          $q->whereHas('user', function ($q) use ($request) {
            $q->where('nama', 'LIKE', '%' . $request->search . '%');
          });
        });
      })->where(function ($q) use ($request) {
        if (isset($request->start) && isset($request->end)) {
          $q->whereBetween('tanggal_diterima', [Carbon::parse($request->start)->startOfDay(), Carbon::parse($request->end)->endOfDay()]);
        } else if (isset($request->tahun) && isset($request->bulan)) {
          $q->whereYear('tanggal_diterima', $request->tahun);
          $q->whereMonth('tanggal_diterima', $request->bulan);
        }
      })->orderBy('kode', 'ASC')->when(auth()->user()->hasRole('customer'), function ($q) {
        $q->whereHas('permohonan', function ($q) {
          $q->where('user_id', auth()->user()->id);
        });
      })->where('status', '>=', 2)->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

      $data->map(function ($a) {
        $a->tanggal_diterima = $a->tanggal_diterima ? AppHelper::tanggal_indo(Carbon::parse($a->tanggal_diterima)->format('Y-m-d')) : '-';
        $a->tanggal_selesai = $a->tanggal_selesai ? AppHelper::tanggal_indo(Carbon::parse($a->tanggal_selesai)->format('Y-m-d')) : '-';

        $a->tracking_status_7 = $a->trackings->where('status', 7)->pluck('created_at')->map(function ($date) {
          return AppHelper::tanggal_indo(Carbon::parse($date)->format('Y-m-d'));
        });
      });

      return response()->json($data);
    } else {
      return abort(404);
    }
  }
}
