<?php

namespace App\Http\Controllers;

use App\Models\LogTTE;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogTTEController extends Controller
{
    public function get()
    {
        return response()->json([
            'data' => LogTTE::with('titik_permohonan')->get()
        ]);
    }

    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = LogTTE::with(['titik_permohonan'])->where(function ($q) use ($request) {
                $q->where('nik', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('status', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('ip_address', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('user_agent', 'LIKE', '%' . $request->search . '%');
                $q->orWhereHas('titik_permohonan', function ($q) use ($request) {
                    $q->where('kode', 'LIKE', '%' . $request->search . '%');
                });
            })->orderBy('created_at', 'desc')->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

            return response()->json($data);
        } else {
            return abort(404);
        }
    }
}
